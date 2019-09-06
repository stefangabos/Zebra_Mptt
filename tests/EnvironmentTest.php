<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 06.09.19
 * Time: 21:53
 */

namespace ZebraTests;


use PHPUnit\Framework\TestCase;
use ZebraTests\Utility\DatabaseStubHelpMethodsInterface;
use ZebraTests\Utility\Environment;
use ZebraTests\Utility\MysqliInMemoryDummy;

class EnvironmentTest extends TestCase
{
    /**
     * @var DatabaseStubHelpMethodsInterface
     */
    private $connection;

    public function setUp(): void
    {
        parent::setUp();
        $this->connection = new MysqliInMemoryDummy();
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