<?php

namespace Crook\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Crook\Config;
use Crook\Hook;

/**
 * Class AddHook
 * @package Crook\Command
 */
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

    /**
     * Creates symlink and add hook-name and hook-action to crook.json
     * configuration file
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $hookName = $input->getArgument('hook-name');
        $hookAction = $input->getArgument('hook-action');

        $hook = new Hook(new Config);

        try {
            $hook->add($hookName, $hookAction);
            $hook->createLink($hookName);
        } catch (\Exception $e) {
            throw new \Exception('Unable to create symlink');
        }
    }
}
