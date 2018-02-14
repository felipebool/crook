<?php

namespace Crook\Command;

use Crook\Hook;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Crook\Config;

/**
 * Class InitHook
 * @package Crook\Command
 */
class InitHook extends Command
{
    protected function configure()
    {
        $this->setName('init');
        $this->setDescription('Init crook files');
    }

    /**
     * Creates crook.json configuration file, copy theHook file to project
     * root directory and make it executable
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = new Config;
        $hook = new Hook($config);

        $config->createCrookConfigFile();

        $hook->copyTheHook();
        $hook->makeTheHookExecutable();
    }
}
