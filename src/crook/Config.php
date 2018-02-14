<?php

namespace Crook;

/**
 * Class Config
 * @package Crook
 */
class Config
{
    /**
     * Returns project root directory
     *
     * @return string
     */
    public function getProjectRoot(): string
    {
        return CROOK_PROJECT_ROOT;
    }

    /**
     * Returns git hooks directory
     *
     * @return string
     */
    public function getGitHookDir()
    {
        return $this->getProjectRoot() . '.git/hooks/';
    }

    /**
     * Returns vendor directory
     *
     * @return string
     */
    public function getVendorDir()
    {
        return $this->getProjectRoot() . 'vendor/';
    }

    /**
     * Returns composer.json content
     *
     * @return array
     */
    public function getComposerContent(): array
    {
        $path = $this->getProjectRoot() . 'composer.json';

        return json_decode(file_get_contents($path), true);
    }

    /**
     * Returns composer path, throws exceptions if it is not defined
     *
     * @return string
     * @throws \Exception
     */
    public function getComposerPath(): string
    {
        $crookConfig = $this->getCrookContent();

        if (isset($crookConfig['composer'])) {
            return $crookConfig['composer'];
        }

        throw new \Exception('Undefined composer path');
    }

    /**
     * Returns crooks.json configuration file path
     *
     * @return string
     */
    public function getCrookPath(): string
    {
        return $this->getProjectRoot() . 'crook.json';
    }

    /**
     * Returns crook.json content
     *
     * @return array
     */
    public function getCrookContent(): array
    {
        $path = $this->getCrookPath();
        $content = file_get_contents($path);

        $content = !empty($content) ? $content : '{}';

        return json_decode($content, true);
    }

    /**
     * Creates crooks.json and returns the amount of bytes written or false,
     * in case of error.
     *
     * @return int
     */
    public function createCrookConfigFile(): int
    {
        $crookFile = $this->getCrookPath();

        return file_put_contents($crookFile, '');
    }

    /**
     * Returns the action for $hook or throws exception
     *
     * @param $hook
     * @return mixed
     * @throws \Exception
     */
    public function getAction($hook)
    {
        $crookContent = $this->getCrookContent();

        if (isset($crookContent[$hook])) {
            return $crookContent[$hook];
        }

        throw new \Exception('Unknown hook action');
    }

    /**
     * Updates crook.json configuration file
     *
     * @param array $newConf
     */
    public function update(array $newConf)
    {
        $crookConf = $this->getCrookPath();
        $fp = fopen($crookConf, 'w');

        fwrite(
            $fp,
            json_encode(
                $newConf,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );
    }
}
