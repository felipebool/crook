<?php

use PHPUnit\Framework\TestCase;
use Crook\Config;
use Dotenv\Dotenv;

class ConfigTest extends TestCase
{
    private $config;

    public function setUp()
    {
        $dotenv = new Dotenv(__DIR__ . '/../../');
        $dotenv->load();

        $this->config = $this
            ->getMockBuilder('Crook\Config')
            ->setMethods(['getProjectRoot'])
            ->getMock();

        $this->config
            ->method('getProjectRoot')
            ->willReturn(getenv('PROJECT_ROOT_DIR'));

        $this->cleanCrookConfFile();
    }

    private function cleanCrookConfFile()
    {
        $crookConf = $this->config->getCrookPath();
        file_put_contents($crookConf, '');
    }

    public function testAddNewHook()
    {
        $result = $this->config->addHook('newHook', 'newAction');

        $this->assertGreaterThan(0, $result);
    }

    public function testRemoveExistentHook()
    {
        $this->config->addHook('newHook', 'newAction');
        $result = $this->config->removeHook('newHook');

        $this->assertGreaterThanOrEqual(0, $result);
    }

    public function testRemoveNonexistentHook()
    {
        $result = $this->config->removeHook('newHook');

        $this->assertEquals(0, $result);
    }

    public function testCreateCrookConfigFile()
    {
        $this->config->createCrookConfigFile();

        $this->assertFileExists($this->config->getCrookPath());
    }

    public function testGetExistentAction()
    {
        $this->config->addHook('newHook', 'newAction');

        $result = $this->config->getAction('newHook');
        $this->assertEquals('newAction', $result);
    }

    /**
     * @expectedException \Exception
     */
    public function testGetNonexistentAction()
    {
        $this->config->getAction('gibberish');
    }

    protected function tearDown()
    {
        unlink($this->config->getCrookPath());
    }
}