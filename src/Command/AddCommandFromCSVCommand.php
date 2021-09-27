<?php
namespace App\Command;

use App\Service\CommandService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddCommandFromCSVCommand extends Command
{
	private CommandService $commandService;
	protected static $defaultName = 'app:add-command';
	const SUCCESS= 0;
	const FAILURE = 1;

	public function __construct(CommandService $commandService)
	{
		$this->commandService = $commandService;
		parent::__construct();
	}

	protected function configure(): void
    {
		$this
			->addArgument('customers', InputArgument::REQUIRED, 'customers csv file')
			->addArgument('purchases', InputArgument::REQUIRED, 'purchases csv file')
			->setDescription('TODO')
			->setHelp('TODO');
    }

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		try {
			$this->commandService->getCommandFromCSV($input->getArgument('customers'), $input->getArgument('purchases'));
		} catch(\Exception $e) {
			dump($e->getMessage());
			return AddCommandFromCSVCommand::FAILURE;
		}

		return AddCommandFromCSVCommand::SUCCESS;
	}
}
