<?php

namespace Crook;

class Application
{
    private $config;
    private $hookType;

    public function __construct(Config $config, string $hookType)
    {
        $this->config = $config;
        $this->hookType = $hookType;
    }

    public function run()
    {
        $action = $this->config->getAction($this->hookType);
        $bin = $this->config->getComposerBinPath();

        $command = $bin . ' run-script ' . $action;

        exec($command, $output, $returnCode);

        return [
            'code' => $returnCode,
            'message' => implode("\n", $output)
        ];
    }
}
