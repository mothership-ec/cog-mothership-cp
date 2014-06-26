<?php

namespace Message\Mothership\ControlPanel\Statistic\Task;

use Message\Cog\Console\Task\Task;

/**
 * Rebuild the statistics.
 *
 * @author Laurence Roberts <laurence@message.co.uk>
 */
class Rebuild extends Task
{
	public function process()
	{
		$datasets = $this->get('statistics');

		$this->writeln('<info>Datasets:</info>');
		foreach ($datasets as $dataset) {
			$this->writeln('<comment>- ' . $dataset->getName());
		}

		$dialog = $this->getHelperSet()->get('dialog');

		$confirm = $dialog->askConfirmation(
			$this->getRawOutput(),
			'<question>Are you sure you wish to clear out all recorded statistics and rebuild with the given datasets (yes/no)?</question>',
			false
		);

		if ($confirm) {
			$this->writeln('<info>Rebuilding:</info>');

			$transaction = $this->get('db.transaction');

			foreach ($datasets as $dataset) {
				$dataset->setTransaction($transaction);
				$dataset->rebuild();
				$this->writeln('<comment>- ' . $dataset->getName());
			}

			try {
				$transaction->commit();
			}
			catch (DB\Exception $exception) {
				$this->writeln('<error>Error, rolling back</error>');
				$this->writeln('<error>' . $exception->getMessage() . '</error>');
			}
		}
	}
}