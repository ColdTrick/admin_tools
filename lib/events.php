<?php
/**
 * All event handlers are bundled here
 */

/**
 * listen to the make admin event to unset the toggle admin flag
 *
 * @param string     $event  the event
 * @param string     $type   the type of the event
 * @param ElggEntity $entity the affected entity
 *
 * @return void
 */
function admin_tools_make_admin_user_event($event, $type, $entity) {
	
	if (empty($entity) || !elgg_instanceof($entity, "user")) {
		return;
	}
	
	elgg_unset_plugin_user_setting("switched_admin", $entity->getGUID(), "admin_tools");
}

/**
 * listen to the remove admin event to unset the toggle admin flag
 *
 * @param string     $event  the event
 * @param string     $type   the type of the event
 * @param ElggEntity $entity the affected entity
 *
 * @return void
 */
function admin_tools_remove_admin_user_event($event, $type, $entity) {
	
	if (empty($entity) || !elgg_instanceof($entity, "user")) {
		return;
	}
	
	elgg_unset_plugin_user_setting("switched_admin", $entity->getGUID(), "admin_tools");
}