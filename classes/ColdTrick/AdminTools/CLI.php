<?php

namespace ColdTrick\AdminTools;

use Elgg\Cli\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

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
			$this->write('Private Settings: ' . $replacement->getPrivateSettingsCount());
			$this->write('Annotations: ' . $replacement->getAnnotationsCount());
			
			$confirm = $this->ask(elgg_echo('admin_tools:cli:change_text:confirm', [$from, $to]) . ' [yes|no] ');
			if ($confirm !== 'yes') {
				$this->write(elgg_echo('admin_tools:cli:change_text:abort'));
				
				return 0;
			}
		}
		
		
		$count = $replacement->run();
		
		$this->write(elgg_echo('admin_tools:cli:change_text:success', [$count]));
		
		return 0;
	}
	
	/**
	 * Registers this command to the list of available CLI commands
	 *
	 * @param \Elgg\Hook $hook 'commands', 'cli'
	 */
	public static function registerCommand(\Elgg\Hook $hook) {
		$return = $hook->getValue();
	    $return[] = self::class;
	    return $return;
	}
}
