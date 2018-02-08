<?php

namespace Crook\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Crook\Config;

class InitHook extends Command
{
    private $crookConfig;

    protected function configure()
    {
        $this->setName('init');
        $this->setDescription('Init crook files');

        $this->crookConfig = new Config;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->crookConfig->createCrookConfigFile();
    }
}
