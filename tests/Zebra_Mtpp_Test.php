<?php

namespace ZebraTests;
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 06.09.19
 * Time: 21:35
 */

use PHPUnit\Framework\TestCase;
use ZebraTests\Utility\Environment;
use ZebraTests\Utility\MysqliInMemoryDummy;

class Zebra_Mtpp_test extends TestCase
{
    /**
     * @var MysqliInMemoryDummy
     */
    private $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new MysqliInMemoryDummy();
        $this->db->query(Environment::getInstallFileContent());
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->db->close();
    }

}