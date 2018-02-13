<?php

namespace Crook\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Crook\Config;
use Crook\Hook;

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

        $hook = new Hook($this->crookConfig);
        $hook->removeLink($hookName);
        $hook->remove($hookName);
    }
}
