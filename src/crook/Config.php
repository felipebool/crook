<?php

namespace Crook;

class Config
{
    private $composerConfig;
    private $crookConfig;
    private $basePath;

    public function getComposerConfigPath(): string
    {
        return CROOK_PROJECT_ROOT . 'composer.json';
    }

    public function getComposerContent(): array
    {
        $path = $this->getComposerConfigPath();

        return json_decode(file_get_contents($path));
    }

    public function getCrookPath(): string
    {
        return CROOK_PROJECT_ROOT . 'crook.json';
    }

    public function getCrookContent(): array
    {
        $path = $this->getCrookConfigPath();

        return json_decode(file_get_contents($path));
    }

    public function getComposerBinPath(): string
    {
        $crookConfig = $this->getCrookContent();

        if (isset($crookConfig['composer'])) {
            return $crookConfig['composer'];
        }

        return CROOK_PROJECT_ROOT . '/vendor/bin/composer';
    }

    public function addHook($hook, $action): void
    {
        $crookConfig = $this->getCrookContent();
        $crookConfig[$hook] = $action;

        $this->saveConfig($crookConfig);
    }

    public function removeHook($hook)
    {
        $crookConfig = $this->getCrookContent();

        if (isset($crookConfig[$hook])) {
            unset($crookConfig[$hook]);
            $this->saveConfig($crookConfig);
        }
    }

    private function saveConfig(array $newConfig)
    {
        $crookFile = $this->getCrookPath();

        file_put_contents(
            $crookFile,
            json_encode($newConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }
}
