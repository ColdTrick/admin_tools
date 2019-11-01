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
	
	public function getMetadataCount() {
		return $this->count('metadata');
	}
	
	public function getPrivateSettingsCount() {
		return $this->count('private_settings');
	}
	
	public function getAnnotationsCount() {
		return $this->count('annotations');
	}
	
	protected function count(string $table_name) {
		$qb = Select::fromTable($table_name);
		$qb->select('COUNT(*) AS total');
		
		$qb->where($qb->compare('value', 'like', "%{$this->from}%", ELGG_VALUE_STRING));

		$result = elgg()->db->getDataRow($qb);

		return empty($result) ? 0 : (int) $result->total;
	}
	
	protected function update(string $table_name) {
		$qb = Update::table($table_name);
		$qb->set('value', "replace(value, '{$this->from}', '{$this->to}')");
		
		$qb->where($qb->compare('value', 'like', "%{$this->from}%", ELGG_VALUE_STRING));

		return elgg()->db->updateData($qb, true);
	}
}
