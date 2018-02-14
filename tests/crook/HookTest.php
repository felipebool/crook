<?php


namespace Crook;

use PHPUnit\Framework\TestCase;

class HookTest extends TestCase
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

    /**
     * @expectedException \Exception
     */
    public function testAddInvalidHook()
    {
        $hook = new Hook($this->config);
        $hook->add('invalid-hook', 'any-action');
    }

    public function testAddValidHook()
    {
        $hook = new Hook($this->config);

        try {
            $result = $hook->add('pre-commit', 'any-action');
        } catch (\Exception $e) {
            $result = 0;
        }

        $this->assertGreaterThan(0, $result);
    }

    public function testRemovePreviouslyAddedHook()
    {
        $hook = new Hook($this->config);
        $hook->add('pre-commit', 'any-action');

        $result = $hook->remove('pre-commit');
        $this->assertGreaterThanOrEqual(0, $result);
    }

    public function testRemoveInexistentHook()
    {
        $hook = new Hook($this->config);
        $result = $hook->remove('inexistent-hook');

        $this->assertGreaterThanOrEqual(0, $result);
    }

    public function tearDown()
    {
        $crookPath = $this->config->getCrookPath();

        if (file_exists($crookPath)) {
            unlink($crookPath);
        }
    }

    public function testGetKnownAction()
    {
        $hook = new Hook($this->config);
        $hook->add('pre-commit', 'any-action');

        $result = $hook->getAction('pre-commit');

        $this->assertEquals('any-action', $result);
    }

    public function testGetUnknownAction()
    {
        $hook = new Hook($this->config);
        $result = $hook->getAction('pre-commit');

        $this->assertEquals('', $result);
    }

    /**
     * @expectedException \Exception
     *
     * @throws \Exception@
     */
    public function testCreateInvalidLink()
    {
        $hook = new Hook($this->config);
        $result = $hook->createLink('invalid-hook');
    }

    public function testCreateValidLink()
    {
        $hook = new Hook($this->config);
        $result = $hook->createLink('pre-commit');

        $this->assertTrue($result);
    }

    /**
     * @depends testCreateValidLink
     */
    public function testRemoveLink()
    {
        $hook = new Hook($this->config);
        $result = $hook->removeLink('pre-commit');

        $this->assertTrue($result);
    }
}
