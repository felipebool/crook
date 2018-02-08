<?php

namespace Crook\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Crook\Config;

class RemoveHook extends Command
{
    private $crookConfig;

    protected function configure()
    {
        $this->setName('remove');
        $this->setDescription('Remove a hook from project');
        $this->addArgument(
            'hook-name',
            InputArgument::REQUIRED,
            'Git hook name'
        );

        $this->crookConfig = new Config;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hookName = $input->getArgument('hook-name');

        $this->removeLink($hookName);
        $this->removeFromConfig($hookName);
    }

    private function removeLink($hook)
    {
        $hookName = $hook;
        $rootDir = dirname(__FILE__, 4);

        $hookPath = $rootDir . '/.git/hooks/' . $hookName;
        unlink($hookPath);
    }

    private function removeFromConfig($hook)
    {
        $this->crookConfig->removeHook($hook);
    }
}