<?php

namespace Crook\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Crook\Config;
use Crook\Hook;

/**
 * Class RemoveHook
 * @package Crook\Command
 */
class RemoveHook extends Command
{
    protected function configure()
    {
        $this->setName('remove');
        $this->setDescription('Remove a hook from project');
        $this->addArgument(
            'hook-name',
            InputArgument::REQUIRED,
            'Git hook name'
        );
    }

    /**
     * Removes link from hook-name to theHook and remove hook-name from
     * crook.json configuration file
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hookName = $input->getArgument('hook-name');

        $hook = new Hook(new Config);

        $hook->removeLink($hookName);
        $hook->remove($hookName);
    }
}
