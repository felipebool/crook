<?php

namespace Crook;

class Config
{
    private $composerConfig;
    private $crookConfig;
    private $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;

        $composerContent = file_get_contents($this->getComposerConfigPath());
        $crookContent = file_get_contents($this->getCrookConfigPath());

        $this->composerConfig = json_decode($composerContent, true);
        $this->crookConfig = json_decode($crookContent, true);
    }

    private function getComposerConfigPath(): string
    {
        return $this->basePath . '/composer.json';
    }

    private function getCrookConfigPath(): string
    {
        return $this->basePath . '/crook.json';
    }

    public function getComposerConfig(): array
    {
        return $this->composerConfig;
    }

    public function getCrookConfig(): array
    {
        return $this->crookConfig;
    }

    public function getComposer(): string
    {
        $crookConfig = $this->getCrookConfig();
        $basePath = $this->getBasePath();

        return $crookConfig['composer'] ?? $basePath . '/vendor/bin/composer';
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function addHook($hook, $action): void
    {
        $crookConfig = $this->getCrookConfig();
        $crookConfig[$hook] = $action;

        $this->saveConfig($crookConfig);
    }

    public function removeHook($hook)
    {
        $crookConfig = $this->getCrookConfig();

        if (isset($crookConfig[$hook])) {
            unset($crookConfig[$hook]);
            $this->saveConfig($crookConfig);
        }
    }

    private function saveConfig(array $newConfig)
    {
        $crookFile = $this->getCrookConfigPath();

        file_put_contents(
            $crookFile,
            json_encode($newConfig, JSON_PRETTY_PRINT)
        );
    }
}
