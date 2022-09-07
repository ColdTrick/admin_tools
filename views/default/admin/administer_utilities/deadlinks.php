<?php

use Elgg\Database\Select;

$selected_types = get_input('types');
$available_types = [];
$limit = (int) get_input('limit', 1000);
$offset = (int) get_input('offset', 0);
$domain = get_input('domain');

$pattern = '~(?xi)
              (?:
                ((ht|f)tps?://)                      # scheme://
                |                                    #   or
                www\d{0,3}\.                         # "www.", "www1.", "www2." ... "www999."
                |                                    #   or
                www\-                                # "www-"
                |                                    #   or
                [a-z0-9.\-]+\.[a-z]{2,4}(?=/)        # looks like domain name followed by a slash
              )
              (?:                                    # Zero or more:
                [^\s()<>]+                           # Run of non-space, non-()<>
                |                                    #   or
                \((?>[^\s()<>]+|(\([^\s()<>]+\)))*\) # balanced parens, up to 2 levels
              )*
              (?:                                    # End with:
                \((?>[^\s()<>]+|(\([^\s()<>]+\)))*\) # balanced parens, up to 2 levels
                |                                    #   or
                [^\s`!\-()\[\]{};:\'".,<>?Â«Â»â€œâ€�â€˜â€™]    # not a space or one of these punct chars
              )
        ~u';

set_time_limit(0);

// base query
$select = Select::fromTable('metadata', 'main');
$select->joinEntitiesTable('main', 'entity_guid', 'left', 'e');

if (empty($domain)) {
	$select->where($select->compare('value', 'like', "%http://%", ELGG_VALUE_STRING, false));
	$select->orWhere($select->compare('value', 'like', "%https://%", ELGG_VALUE_STRING, false));
} else {
	$select->where($select->compare('value', 'like', "%http://{$domain}%", ELGG_VALUE_STRING, false));
	$select->orWhere($select->compare('value', 'like', "%https://{$domain}%", ELGG_VALUE_STRING, false));
}

$select->andWhere($select->compare('name', '=', 'description', ELGG_VALUE_STRING, false));
$select->andWhere($select->compare('e.enabled', '=', 'yes', ELGG_VALUE_STRING, false));
$select->andWhere($select->compare('e.access_id', '<>', ACCESS_PRIVATE, ELGG_VALUE_INTEGER));

// grouped
if (empty($selected_types)) {
	$select_counts = clone $select;
	$select_counts->select('e.type')->addSelect('e.subtype')->addSelect('count(*) as total');
	
	$select_counts->groupBy('e.type')->addGroupBy('e.subtype');
	
	$available_results = elgg()->db->getData($select_counts);
	foreach ($available_results as $row) {
		$available_types["{$row->type}.{$row->subtype}"] = elgg_echo("item:{$row->type}:{$row->subtype}") . " ({$row->total})";
	}
	
	if (empty($available_types)) {
		echo elgg_echo('notfound');
		return;
	}
} else {
	list($type, $subtype) = explode('.', $selected_types);
	$available_types[$selected_types] = elgg_echo("item:{$type}:{$subtype}");
}


// form
echo elgg_view_form('admin_tools/deadlinks', [
	'action' => 'admin/administer_utilities/deadlinks',
	'method' => 'GET',
	'class' => 'mbl',
], [
	'types' => $available_types,
	'selected_types' => $selected_types,
]);

if (empty($selected_types)) {
	return;
}

// listing
$fetch_status_code = function ($url) {
	// create a new cURL resource
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	
	// This changes the request method to HEAD
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // connect timeout
	curl_setopt($ch, CURLOPT_TIMEOUT, 10); // curl timeout
	curl_setopt($ch, CURLOPT_URL, $url);

	$result = curl_exec($ch) ? curl_getinfo($ch, CURLINFO_HTTP_CODE) : 0;
	
	curl_close($ch);
	
	return $result;
};

list($type, $subtype) = explode('.', $selected_types);

$qb = clone $select;
$qb->select('main.value')->addSelect('main.entity_guid');

$qb->andWhere($qb->compare('e.type', '=', $type, ELGG_VALUE_STRING));
$qb->andWhere($qb->compare('e.subtype', '=', $subtype, ELGG_VALUE_STRING));

$count_select = clone $qb;
$count_select->select('count(*) as total');
$count_results = elgg()->db->getDataRow($count_select);
$count = $count_results->total;

$qb->setFirstResult($offset);
$qb->setMaxResults($limit);

$results = elgg()->db->getData($qb);

$links = [];
foreach ($results as $result) {
	$matches = [];
	preg_match_all($pattern, $result->value, $matches);
	$matches = array_unique($matches[0]);

	foreach ($matches as $match) {
		if (!empty($domain) && !stristr($match, $domain)) {
			continue;
		}
		
		if (!isset($links[$match])) {
			$links[$match] = [];
		}
		
		if (in_array($result->entity_guid, $links[$match])) {
			continue;
		}
		
		$links[$match][] = $result->entity_guid;
	}
}

$table = '<table class="elgg-table">';
$table .= '<thead><tr><th>link</th><th>status</th><th>content</th></tr></thead>';
ksort($links);
foreach ($links as $link => $guids) {
	$code = $fetch_status_code($link);
	if ($code === 200) {
		continue;
	}
	
	$table .= '<tr>';
	$table .= '<td>' . $link . '</td>';
	$table .= '<td>' . $code . '</td>';
	$table .= '<td>';
	foreach ($guids as $guid) {
		$table .= elgg_view_url(elgg_generate_url('deadlinks:redirect', ['guid' => $guid]), $guid) . '<br />';
	}
	$table .= '</td>';
	$table .= '</tr>';
}
$table .= '</table>';

$table .= elgg_view('navigation/pagination', [
	'count' => $count,
	'limit' => $limit,
	'offset' => $offset,
]);

echo elgg_view_module('info', 'results (' . count($links) . ' urls scanned)', $table);
