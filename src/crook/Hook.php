<?php

namespace Crook;

/**
 * Class Hook
 * @package Crook
 */
class Hook
{
    /**
     * @var Config
     */
    private $config;

    /**
     * Hook constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Add new hook $name with action $action
     *
     * @param $name
     * @param $action
     * @return bool
     * @throws \Exception
     */
    public function add($name, $action): bool
    {
        if (!in_array($name, $this->getAvailableHooks())) {
            throw new \Exception('Invalid hook name: ' . $name);
        }

        $crookConf = $this->config->getCrookContent();
        $crookConf[$name] = $action;

        return $this->config->update($crookConf);
    }

    /**
     * Remove $name hook from crook.json
     *
     * @param $name
     * @return bool|int
     */
    public function remove($name)
    {
        $crookConf = $this->config->getCrookContent();
        unset($crookConf[$name]);

        return $this->config->update($crookConf);
    }

    /**
     * Get action for $name hook
     *
     * @param $name
     * @return string
     */
    public function getAction($name): string
    {
        $crookConf = $this->config->getCrookContent();

        return $crookConf[$name] ?? '';
    }

    /**
     * Create link from .git/hooks/$name to theHook
     *
     * @param $name
     * @return bool
     */
    public function createLink($name): bool
    {
        $gitHookPath = $this->config->getGitHookDir() . $name;
        $theHookPath = $this->config->getProjectRoot() . 'theHook';

        if (!in_array($name, $this->getAvailableHooks())) {
            throw new \Exception('Invalid hook name: ' . $name);
        }

        return symlink($theHookPath, $gitHookPath);
    }

    /**
     * Remove link from .git/hooks/$name to theHook
     *
     * @param $name
     * @return bool
     */
    public function removeLink($name): bool
    {
        $gitHookPath = $this->config->getGitHookDir() . $name;

        return unlink($gitHookPath);
    }

    /**
     * Copy theHook file from package vendot to project root directory
     */
    public function copyTheHook()
    {
        $source = $this->config->getVendorDir() . 'felipebool/crook/theHook';
        $destination = $this->config->getProjectRoot() . 'theHook';

        copy($source, $destination);
    }

    /**
     * Make theHook executable
     */
    public function makeTheHookExecutable()
    {
        $theHookPath = $this->config->getProjectRoot() . 'theHook';

        chmod($theHookPath, 0755);
    }

    private function getAvailableHooks()
    {
        return [
            'applypatch-msg',
            'pre-applypatch',
            'post-applypatch',
            'pre-commit',
            'prepare-commit-msg',
            'commit-msg',
            'post-commit',
            'pre-rebase',
            'post-checkout',
            'post-merge',
            'pre-push',
            'pre-receive',
            'update',
            'post-receive',
            'post-update',
            'pre-auto-gc',
            'post-rewrite'
        ];
    }
}
