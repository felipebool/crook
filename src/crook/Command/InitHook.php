<?php

namespace Crook\Command;

use Crook\Hook;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Crook\Config;

class InitHook extends Command
{
    protected function configure()
    {
        $this->setName('init');
        $this->setDescription('Init crook files');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = new Config;
        $hook = new Hook($config);

        $config->createCrookConfigFile();

        $hook->copyTheHook();
        $hook->makeTheHookExecutable();
    }
}
