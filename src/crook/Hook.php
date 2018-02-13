<?php

namespace Crook;

class Hook
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function add($name, $action)
    {
        $crookConf = $this->config->getCrookContent();
        $crookConf[$name] = $action;

        $this->config->update($crookConf);
    }

    public function remove($name)
    {
        $crookConf = $this->config->getCrookContent();
        unset($crookConf[$name]);

        $this->config->update($crookConf);
    }

    public function update($name, $action)
    {
        $this->add($name, $action);
    }

    public function getAction($name)
    {
        $crookConf = $this->config->getCrookContent();

        return $crookConf[$name];
    }

    public function createLink($name)
    {
        $gitHookPath = $this->config->getGitHookDir() . $name;
        $theHookPath = $this->config->getProjectRoot() . 'theHook';

        symlink($theHookPath, $gitHookPath);
    }
}
