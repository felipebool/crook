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
        $action = $this->getAction($this->hookType);
        $bin = $this->config->getComposer();

        $command = $bin . ' run-script ' . $action;

        exec($command, $output, $returnCode);

        return [
            'code' => $returnCode,
            'message' => implode("\n", $output)
        ];
    }

    private function getAction($hook): string
    {
        $crook = $this->config->getCrookConfig();

        if (!isset($crook[$hook])) {
            throw new \Exception('Hook action not defined');
        }

        return $crook[$hook];
    }
}
