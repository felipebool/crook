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
     */
    public function add($name, $action)
    {
        $crookConf = $this->config->getCrookContent();
        $crookConf[$name] = $action;

        $this->config->update($crookConf);
    }

    /**
     * Remove $name hook from crook.json
     *
     * @param $name
     */
    public function remove($name)
    {
        $crookConf = $this->config->getCrookContent();
        unset($crookConf[$name]);

        $this->config->update($crookConf);
    }

    /**
     * Update action for $name hook
     *
     * @param $name
     * @param $action
     */
    public function update($name, $action)
    {
        $this->add($name, $action);
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

        return $crookConf[$name];
    }

    /**
     * Create link from .git/hooks/$name to theHook
     *
     * @param $name
     */
    public function createLink($name)
    {
        $gitHookPath = $this->config->getGitHookDir() . $name;
        $theHookPath = $this->config->getProjectRoot() . 'theHook';

        symlink($theHookPath, $gitHookPath);
    }

    /**
     * Remove link from .git/hooks/$name to theHook
     *
     * @param $name
     */
    public function removeLink($name)
    {
        $gitHookPath = $this->config->getGitHookDir() . $name;

        unlink($gitHookPath);
    }

    public function copyTheHook()
    {
        $source = $this->config->getVendorDir() . 'felipebool/crook/theHook';
        $destination = $this->config->getProjectRoot() . 'theHook';

        copy($source, $destination);
    }

    public function makeTheHookExecutable()
    {
        $theHookPath = $this->config->getProjectRoot() . 'theHook';

        chmod($theHookPath, 0755);
    }
}
