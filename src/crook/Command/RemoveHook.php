<?php

namespace Crook\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $rootDir = dirname(__FILE__, 4);
        $crookConfigPath = $rootDir . '/crook.json';
        $crookConfig = json_decode(file_get_contents($crookConfigPath), true);

        if (isset($crookConfig[$hook])) {
            // remove configuration
            unset($crookConfig[$hook]);

            // avoid saving empty array
            $crookConfig = $crookConfig ?? '';

            // update config file
            file_put_contents(
                $crookConfigPath,
                json_encode($crookConfig, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES)
            );
        }
    }
}