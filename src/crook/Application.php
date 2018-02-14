<?php

namespace Crook;

/**
 * Class Application
 * @package Crook
 */
class Application
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var string
     */
    private $hookType;

    public function __construct(Config $config, string $hookType)
    {
        $this->config = $config;
        $this->hookType = $hookType;
    }

    /**
     * Gets the action to $hookType and execute it, returning the error
     * message and code if something goes wrong
     *
     * @return array
     */
    public function run()
    {
        $hook = new Hook($this->config);

        try {
            $action = $hook->getAction($this->hookType);
            $bin = $this->config->getComposerPath();
        } catch (\Exception $e) {
            return [
                'code' => 23,
                'message' => $e->getMessage() . "\n"
            ];
        }

        $command = $bin . ' run-script ' . $action;
        exec($command, $output, $returnCode);

        return [
            'code' => $returnCode,
            'message' => implode("\n", $output)
        ];
    }
}
