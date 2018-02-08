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
        $scriptAction = $this->config->getCrookConfig()[$this->hookType];
        $composer = $this->config->getCrookConfig()['composer'];
        $parameter = ' run-script ';
        $suppressError = ' 2> /dev/null';

        $command = $composer . $parameter . $scriptAction;// . $suppressError;

        exec($command, $output, $returnCode);

        return [
            'code' => $returnCode,
            'message' => implode("\n", $output)
        ];
    }
}
