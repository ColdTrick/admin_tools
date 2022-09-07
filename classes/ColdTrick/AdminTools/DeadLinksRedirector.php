<?php

namespace ColdTrick\AdminTools;

use Elgg\Exceptions\Http\EntityNotFoundException;
use Elgg\Http\ResponseBuilder;
use Elgg\Request;

/**
 * Redirect a entity guid to the full view of the entity
 */
class DeadLinksRedirector {
	
	/**
	 * Redirect to the entity url
	 *
	 * @param Request $request the Elgg request
	 *
	 * @return ResponseBuilder
	 * @throws EntityNotFoundException
	 */
	public function __invoke(Request $request) {
		
		$guid = (int) $request->getParam('guid');
		
		$entity = get_entity($guid);
		if (!$entity instanceof \ElggEntity) {
			throw new EntityNotFoundException();
		}
		
		return elgg_redirect_response($entity->getURL());
	}
}
