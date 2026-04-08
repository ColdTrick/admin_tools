<?php

namespace ColdTrick\AdminTools\Notifications;

use Elgg\Notifications\InstantNotificationEventHandler;

/**
 * Notify an admin about the deadlinks in content
 */
class DeadLinks extends InstantNotificationEventHandler {
	
	/**
	 * {@inheritdoc}
	 */
	public function getNotificationSubject(\ElggUser $recipient, string $method): string {
		return elgg_echo('admin_tools:notification:deadlinks:subject');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getNotificationSummary(\ElggUser $recipient, string $method): string {
		return elgg_echo('admin_tools:notification:deadlinks:summary');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getNotificationBody(\ElggUser $recipient, string $method): string {
		return elgg_echo('admin_tools:notification:deadlinks:body', [
			$this->getParam('deadlinks_count'),
			$this->getParam('url'),
		]);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getNotificationURL(\ElggUser $recipient, string $method): string {
		return $this->getParam('url');
	}
}
