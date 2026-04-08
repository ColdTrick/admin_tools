<?php

namespace ColdTrick\AdminTools\Controllers\Actions;

/**
 * Export text change extended data
 */
class ChangeTextExportExtended extends ChangeTextExport {
	
	/**
	 * {@inheritdoc}
	 */
	protected function getContentHeaders(): array {
		return [
			'GUID',
			'Type',
			'Subtype',
			'URL',
			'Owner name',
			'Owner URL',
			'Owner e-mail',
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
			$entity = get_entity($row->entity_guid);
			
			$entity_url = '';
			$owner = false;
			if ($entity instanceof \ElggEntity) {
				$entity_url = $entity->getURL();
				$owner = $entity->getOwnerEntity();
			}
			
			$result[] = [
				(int) $row->entity_guid,
				$row->type,
				$row->subtype,
				$entity_url,
				$owner ? $owner->getDisplayName() : '',
				$owner ? $owner->getURL() : '',
				$owner ? $owner->email : '',
				(int) $row->id,
				$row->name,
				$row->value,
			];
		}
		
		return $result;
	}
}
