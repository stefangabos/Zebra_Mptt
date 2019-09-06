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
        $this->assertFileExists( $this->getInstallFilePath(), "Install file doesn't exists");
    }

    public function testInstall(){
        $content = $this->getInstallFileContent();
        $this->connection->query($content);
        $this->assertEquals(true, $this->connection->tableExists('mptt'),"Installing script doesn't work");
    }

    private function getInstallFilePath():string{
        return __DIR__.'/../install/mptt.sql';
    }

    private function getInstallFileContent():string
    {
        $content = file_get_contents($this->getInstallFilePath());
        $content = $this->removeMysqlPart($content);
        return rtrim(trim($content),';');
    }

    private function removeMysqlPart($content)
    {
        $replacement = [
            ' ENGINE=InnoDB DEFAULT CHARSET=utf8'=>'',
            'auto_increment'=>''
        ];
        return str_replace(array_keys($replacement),array_values($replacement),$content);
    }
}