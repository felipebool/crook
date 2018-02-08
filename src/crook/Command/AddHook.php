<?php

namespace Crook\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddHook extends Command
{
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
        $hookName = $hook;
        $rootDir = dirname(__FILE__, 4);

        $newHookPath = $rootDir . '/.git/hooks/' . $hookName;
        $theHookPath = $rootDir . '/hooks/theHook';

        symlink($theHookPath, $newHookPath);
    }

    private function addHookToCrook($hookName, $hookAction)
    {
        $rootDir = dirname(__FILE__, 4);
        $crookConfigPath = $rootDir . '/crook.json';
        $crookConfig = json_decode(file_get_contents($crookConfigPath), true);

        // add hook configuration
        $crookConfig[$hookName] = $hookAction;

        // update file
        file_put_contents(
            $crookConfigPath,
            json_encode($crookConfig, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES)
        );
    }
}