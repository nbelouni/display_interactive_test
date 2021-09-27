<?php
namespace App\Command;

use App\Service\CommandService;
use Symfony\Component\Console\Command\Command;
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
			->setDescription('TODO')
			->setHelp('TODO');
    }

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		if (count($input->getArguments()) !== 2) {
			dump("No requiresd arguments. (see app:add-command --help)");
			return AddCommandFromCSVCommand::FAILURE;
		}

		try {
			$this->commandService->getCommandFromCSV($input->getArguments()[0], $input->getArguments()[1]);
		} catch(\Exception $e) {
			dump($e->getMessage());
			return AddCommandFromCSVCommand::FAILURE;
		}

		return AddCommandFromCSVCommand::SUCCESS;
	}
}
