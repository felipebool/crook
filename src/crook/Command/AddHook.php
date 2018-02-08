<?php

namespace Crook\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Crook\Config;

class AddHook extends Command
{
    private $crookConfig;

    protected function configure()
    {
        $this->setName('add');
        $this->setDescription('Add a new hook to project');
        $this->addArgument(
            'hook-name',
            InputArgument::REQUIRED,
            'Git hook name'
        );
        $this->addArgument(
            'hook-action',
            InputArgument::REQUIRED,
            'Composer action'
        );

        $this->crookConfig = new Config;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hookName = $input->getArgument('hook-name');
        $hookAction = $input->getArgument('hook-action');

        try {
            $this->createLink($hookName);
            $this->addHookToCrook($hookName, $hookAction);
        } catch (\Exception $e) {
            throw new \Exception('Unable to create symlink');
        }
    }

    private function createLink($hook): void
    {
        $rootDir = $this->crookConfig->getProjectRoot();

        $newHookPath = $rootDir . '/.git/hooks/' . $hook;
        $theHookPath = $rootDir . '/hooks/theHook';

        symlink($theHookPath, $newHookPath);
    }

    private function addHookToCrook($hookName, $hookAction): void
    {
        $this->crookConfig->addHook($hookName, $hookAction);
    }
}
