<?php

namespace ColdTrick\AdminTools\Controllers\Actions;

use ColdTrick\AdminTools\Replacement;
use Elgg\Controllers\GenericAction;
use Elgg\Database\AnnotationsTable;
use Elgg\Database\MetadataTable;
use Elgg\Exceptions\Http\BadRequestException;
use Elgg\Http\OkResponse;

/**
 * Change text in the database
 */
class ChangeText extends GenericAction {
	
	protected ?string $from = null;
	
	protected ?string $to = null;
	
	protected ?Replacement $replacement = null;
	
	protected int $num_rows = 0;
	
	/**
	 * {@inheritdoc}
	 */
	protected function validate(): void {
		$from = $this->request->getParam('from');
		$to = $this->request->getParam('to');
		
		if (elgg_is_empty($from) || elgg_is_empty($to)) {
			throw new BadRequestException(elgg_echo('error:missing_data'));
		}
		
		$this->from = $from;
		$this->to = $to;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function executeBefore(): void {
		$this->replacement = new Replacement($this->from, $this->to);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function execute(): void {
		$this->num_rows = $this->replacement->run();
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function success(): OkResponse {
		return elgg_ok_response('', elgg_echo('admin_tools:action:change_text:success', [$this->num_rows]));
	}
}
