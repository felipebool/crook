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
        $this->copyTheHook();
        $this->makeTheHookExecutable();
    }

    private function copyTheHook()
    {
        $root = $this->crookConfig->getProjectRoot();

        $source = $root . 'vendor/felipebool/crook/theHook';
        $destination = $root . 'theHook';

        copy($source, $destination);
    }

    private function makeTheHookExecutable()
    {
        $root = $this->crookConfig->getProjectRoot();

        $theHookPath = $root . 'theHook';
        chmod($theHookPath, 0755);
    }
}

