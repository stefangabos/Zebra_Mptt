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
use ZebraTests\Utility\InMemoryDriver;

class Zebra_Mtpp_Test extends TestCase
{
    /**
     * @var InMemoryDriver
     */
    private $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new InMemoryDriver();
        $this->db->query(Environment::getInstallFileContent());
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->db->close();
    }

}