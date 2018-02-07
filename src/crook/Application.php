<?php

namespace Crook;

class Application
{
    private $crook;
    private $composer;
    private $hookType;

    public function __construct(Config $crook, Config $composer, string $hookType)
    {
        $this->composer = $composer;
        $this->crook = $crook;
        $this->hookType = $hookType;
    }

    public function run()
    {
        exit(23);
    }
}
