<?php

namespace ColdTrick\AdminTools\Controllers\Actions;

use ColdTrick\AdminTools\Replacement;
use Elgg\Controllers\CsvDownloadAction;
use Elgg\Database\AnnotationsTable;
use Elgg\Database\MetadataTable;
use Elgg\Exceptions\Http\BadRequestException;

/**
 * Export text change data
 */
class ChangeTextExport extends CsvDownloadAction {
	
	protected ?string $from = null;
	
	protected ?string $table = null;
	
	protected ?Replacement $replacement = null;
	
	/**
	 * {@inheritdoc}
	 */
	protected function validate(): void {
		$from = $this->request->getParam('from');
		$table = $this->request->getParam('type');
		
		if (elgg_is_empty($from) || empty($table)) {
			throw new BadRequestException(elgg_echo('error:missing_data'));
		}
		
		if (!in_array($table, [
			AnnotationsTable::TABLE_NAME,
			MetadataTable::TABLE_NAME,
		])) {
			throw new BadRequestException(elgg_echo('error:missing_data'));
		}
		
		$this->from = $from;
		$this->table = $table;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function executeBefore(): void {
		$this->replacement = new Replacement($this->from, 'dummy');
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getFilename(): string {
		return date('Y-m-d') . "-{$this->table}.csv";
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getContentHeaders(): array {
		return [
			'GUID',
			'Type',
			'Subtype',
			'URL',
			'ID',
			'Name',
			'Value',
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getContentRows(): array {
		$result = [];
		
		$data = $this->replacement->getExportResults($this->table);
		foreach ($data as $row) {
			$entity_url = '';
			if ($row->guid > 0) {
				$entity_url = elgg_generate_url("view:{$row->type}:{$row->subtype}", [
					'guid' => (int) $row->guid,
				]) ?: '';
			}
			
			$result[] = [
				(int) $row->entity_guid,
				$row->type,
				$row->subtype,
				$entity_url,
				(int) $row->id,
				$row->name,
				$row->value,
			];
		}
		
		return $result;
	}
}
