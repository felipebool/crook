<?php

namespace Crook;


class Config
{
    private $configData;
    private $composerConfig;
    private $crookConfig;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;

        $this->composerConfig = json_decode(
            file_get_contents($this->basePath . '/composer.json'),
            true
        );
        $this->crookConfig = json_decode(
            file_get_contents($this->basePath . '/crook.json'),
            true
        );
    }

    public function getComposerConfig()
    {
        return $this->composerConfig;
    }

    public function getCrookConfig()
    {
        return $this->crookConfig;
    }

    public function getComposer()
    {
        return $this->crookConfig['composer'];
    }
}