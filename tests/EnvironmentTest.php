<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 06.09.19
 * Time: 21:53
 */

namespace ZebraTests\Mptt;


use PHPUnit\Framework\TestCase;
use ZebraTests\Mptt\Utility\Environment;
use ZebraTests\Mptt\Utility\InMemoryDriver;

class EnvironmentTest extends TestCase
{
    /**
     * @var InMemoryDriver
     */
    private $connection;

    public function setUp(): void
    {
        parent::setUp();
        $this->connection = new InMemoryDriver();
    }

    public function tearDown(): void
    {
        $this->connection->close();
        parent::tearDown();
    }

    public function testInstallFileExists(){
        $this->assertFileExists( Environment::getInstallFilePath(), "Install file doesn't exists");
    }

    public function testInstall(){
        $content = Environment::getInstallFileContent();
        $this->connection->query($content);
        $this->assertEquals(true, $this->connection->tableExists('mptt'),"Installing script doesn't work");
    }

}