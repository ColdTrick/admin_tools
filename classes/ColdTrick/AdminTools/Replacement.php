<?php

namespace ColdTrick\AdminTools;

use Elgg\Database\Select;
use Elgg\Database\Update;

class Replacement {
	
	protected $from;
	protected $to;
	
	public function __construct(string $from, string $to) {
		$this->from = $from;
		$this->to = $to;
	}
	
	/**
	 * Executes the replacements and returns the total rows affected
	 *
	 * @return int total rows affected
	 */
	public function run() {
		$total = 0;
		$total += $this->update('annotations');
		$total += $this->update('metadata');
		$total += $this->update('private_settings');
		
		return $total;
	}
	
	/**
	 * Get replacement count for metadata table
	 *
	 * @return int
	 */
	public function getMetadataCount() {
		return $this->count('metadata');
	}
	
	/**
	 * Get replacement count for private_settingstable
	 *
	 * @return int
	 */
	public function getPrivateSettingsCount() {
		return $this->count('private_settings');
	}
	
	/**
	 * Get replacement count for annotations table
	 *
	 * @return int
	 */
	public function getAnnotationsCount() {
		return $this->count('annotations');
	}
	
	/**
	 * Get replacement rows for given table
	 *
	 * @param string $table 'annotations', 'metadata' or 'private_settings'
	 *
	 * @return array
	 */
	public function getExportResults(string $table) {
		if (!in_array($table, ['annotations', 'metadata', 'private_settings'])) {
			return [];
		}
		
		$qb = Select::fromTable($table, 'main');
		$qb->joinEntitiesTable('main', 'entity_guid', 'left', 'e');
		
		$qb->select('main.name')
			->addSelect('main.value')
			->addSelect('main.entity_guid')
			->addSelect('main.id')
			->addSelect('e.guid')
			->addSelect('e.type')
			->addSelect('e.subtype');
		
		$qb->where($qb->compare('value', 'like', "%{$this->from}%", ELGG_VALUE_STRING, true));
		
		$qb->orderBy('main.entity_guid', 'ASC');
		$qb->addOrderBy('main.name', 'ASC');
		
		return elgg()->db->getData($qb);
	}
	
	/**
	 * Get count form table
	 *
	 * @param string $table_name table name
	 *
	 * @return int
	 */
	protected function count(string $table_name) {
		$qb = Select::fromTable($table_name);
		$qb->select('COUNT(*) AS total');
		
		$qb->where($qb->compare('value', 'like', "%{$this->from}%", ELGG_VALUE_STRING, true));

		$result = elgg()->db->getDataRow($qb);

		return empty($result) ? 0 : (int) $result->total;
	}
	
	/**
	 * Update table
	 *
	 * @param string $table_name table name
	 *
	 * @return bool|int
	 */
	protected function update(string $table_name) {
		$qb = Update::table($table_name);
		$qb->set('value', "replace(value, '{$this->from}', '{$this->to}')");
		
		$qb->where($qb->compare('value', 'like', "%{$this->from}%", ELGG_VALUE_STRING, true));

		return elgg()->db->updateData($qb, true);
	}
}
