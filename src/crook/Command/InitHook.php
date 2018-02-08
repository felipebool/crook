<?php

namespace Crook\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitHook extends Command
{
    protected function configure()
    {
        $this->setName('init');
        $this->setDescription('Init crook files');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rootDir = dirname(__FILE__, 4);
        $crookConfigPath = $rootDir . '/crook.json';

        $handle = fopen($crookConfigPath, 'w');
        fclose($handle);
    }
}
