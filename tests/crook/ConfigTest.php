<?php

namespace Crook;

use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    private $config;

    public function setUp()
    {
        $this->config = $this
            ->getMockBuilder('Crook\Config')
            ->setMethods(['getProjectRoot'])
            ->getMock();

        $this
            ->config
            ->method('getProjectRoot')
            ->willReturn(__DIR__ . '/../../');
    }

    public function testCreateCrookConfigFile()
    {
        $result = $this->config->createCrookConfigFile();

        $this->assertFileExists($this->config->getCrookPath());
        $this->assertGreaterThanOrEqual(0, $result);
    }

    /**
     * @depends testCreateCrookConfigFile
     */
    public function testUpdate()
    {
        $newConf = [
          'pre-commit' => 'any-action'
        ];

        $result = $this->config->update($newConf);
        $expected = strlen(json_encode(
            $newConf,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        ));

        $this->assertEquals($expected, $result);
    }
}
