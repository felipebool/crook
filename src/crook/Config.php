<?php

namespace Crook;

class Config
{
    public function getProjectRoot(): string
    {
        return CROOK_PROJECT_ROOT;
    }

    public function getComposerConfigPath(): string
    {
        return $this->getProjectRoot() . 'composer.json';
    }

    public function getComposerContent(): array
    {
        $path = $this->getComposerConfigPath();

        return json_decode(file_get_contents($path), true);
    }

    public function getCrookPath(): string
    {
        return $this->getProjectRoot() . 'crook.json';
    }

    public function getCrookContent(): array
    {
        $path = $this->getCrookPath();
        $content = file_get_contents($path);

        $content = !empty($content) ? $content : '{}';

        return json_decode($content, true);
    }

    public function getComposerBinPath(): string
    {
        $crookConfig = $this->getCrookContent();

        if (isset($crookConfig['composer'])) {
            return $crookConfig['composer'];
        }

        return $this->getProjectRoot() . 'vendor/bin/composer';
    }

    public function addHook($hook, $action)
    {
        $crookConfig = $this->getCrookContent();
        $crookConfig[$hook] = $action;

        return $this->saveConfig($crookConfig);
    }

    public function removeHook($hook)
    {
        $crookConfig = $this->getCrookContent();
        unset($crookConfig[$hook]);

        return $this->saveConfig($crookConfig);
    }

    private function saveConfig(array $newConfig)
    {
        $crookFile = $this->getCrookPath();
        $content = '';

        if (!empty($newConfig)) {
            $content = json_encode(
                $newConfig,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            );
        }

        return file_put_contents($crookFile, $content);
    }

    public function createCrookConfigFile(): int
    {
        $crookFile = $this->getCrookPath();

        return file_put_contents($crookFile, '');
    }

    public function getAction($hook)
    {
        $crookContent = $this->getCrookContent();

        if (isset($crookContent[$hook])) {
            return $crookContent[$hook];
        }

        throw new \Exception('Unknown hook action');
    }
}

