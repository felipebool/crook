<?php

namespace Crook;

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

class ApplicationTest extends TestCase
{
    private $config;

    public function setUp()
    {
        $this->config = $this
            ->getMockBuilder('Crook\Config')
            ->setMethods(['getProjectRoot', 'getComposerPath'])
            ->getMock();

        $this
            ->config
            ->method('getProjectRoot')
            ->willReturn(__DIR__ . '/../../');

        if (file_exists(__DIR__ . '/../../.env')) {
            $dotenv = new Dotenv(__DIR__ . '/../../');
            $dotenv->load();
        }

        $this
            ->config
            ->method('getComposerPath')
            ->willReturn(getenv('COMPOSER_BIN'));
    }

    public function testPreCommitHookTypeWithNonPsrCodeRun()
    {
        $app = new Application($this->config, 'pre-commit');
        $hook = new Hook($this->config);

        $hook->add('pre-commit', 'code-check-non-psr2');
        $result = $app->run();

        $this->assertContains('FOUND 3 ERRORS AFFECTING 2 LINES', $result['message']);
        $this->assertGreaterThan(0, $result['code']);
    }

    public function testPreCommitHookTypeWithPsrCodeRun()
    {
        $app = new Application($this->config, 'pre-commit');
        $hook = new Hook($this->config);

        $hook->add('pre-commit', 'code-check-psr2');
        $result = $app->run();

        $this->assertEquals('', $result['message']);
        $this->assertEquals(0, $result['code']);
    }
}
