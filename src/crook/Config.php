<?php

namespace Crook;


class Config
{
    private $configData;

    public function __construct($configPath)
    {
        $this->configData = json_decode(file_get_contents($configPath));
    }

    public function __get($name)
    {
        if (isset($this->configData[$name])) {
            return $this->configData[$name];
        }

    }
}