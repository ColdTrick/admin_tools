<?php

namespace ColdTrick\AdminTools;

use Elgg\Cli\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * CLI command to change text in the database
 */
class CLI extends Command {
	
	/**
	 * {@inheritdoc}
	 */
	protected function configure() {
		$this->setName('change_text')
			->setDescription(elgg_echo('admin_tools:cli:change_text:description'))
			->addArgument('from', InputArgument::REQUIRED,
				elgg_echo('admin_tools:cli:change_text:from')
			)
			->addArgument('to', InputArgument::REQUIRED,
				elgg_echo('admin_tools:cli:change_text:to')
			);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function command() {
		$from = $this->argument('from');
		$to = $this->argument('to');
		$replacement = new Replacement($from, $to);
		
		if (!$this->option('no-interaction')) {
			$this->write('Metadata: ' . $replacement->getMetadataCount());
			$this->write('Annotations: ' . $replacement->getAnnotationsCount());
			
			$confirm = $this->ask(elgg_echo('admin_tools:cli:change_text:confirm', [$from, $to]) . ' [yes|no] ');
			if (!str_starts_with($confirm, 'y')) {
				$this->write(elgg_echo('admin_tools:cli:change_text:abort'));
				
				return self::SUCCESS;
			}
		}
		
		$count = $replacement->run();
		
		$this->write(elgg_echo('admin_tools:cli:change_text:success', [$count]));
		
		return self::SUCCESS;
	}
	
	/**
	 * Registers this command to the list of available CLI commands
	 *
	 * @param \Elgg\Event $event 'commands', 'cli'
	 *
	 * @return array
	 */
	public static function registerCommand(\Elgg\Event $event): array {
		$return = $event->getValue();
		$return[] = self::class;
		
		return $return;
	}
}
