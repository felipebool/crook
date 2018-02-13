<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

class ApplicationTest extends TestCase
{
    public function setUp()
    {
        $dotenv = new Dotenv(__DIR__ . '/../../');
        $dotenv->load();
    }

    public function testRunWithPreCommitHookAndFailing()
    {
        $config = $this
            ->getMockBuilder('Crook\Config')
            ->setMethods(['getComposerBinPath', 'getAction'])
            ->getMock();

        $config
            ->method('getComposerBinPath')
            ->willReturn(getenv('COMPOSER_BIN'));

        $config
            ->method('getAction')
            ->willReturn('code-check-not-psr2');

        $app = new \Crook\Application($config, 'pre-commit');

        $result = $app->run();

        $this->assertGreaterThan(0, $result['code']);
        $this->assertContains('FOUND 4 ERRORS AFFECTING 3 LINES', $result['message']);
    }

    public function testRunWithPreCommitHookAndHavingSuccess()
    {
        $config = $this
            ->getMockBuilder('Crook\Config')
            ->setMethods(['getComposerBinPath', 'getAction'])
            ->getMock();

        $config
            ->method('getComposerBinPath')
            ->willReturn(getenv('COMPOSER_BIN'));

        $config
            ->method('getAction')
            ->willReturn('code-check-psr2');

        $app = new \Crook\Application($config, 'pre-commit');

        $result = $app->run();

        $this->assertEquals(0, $result['code']);
    }
}
