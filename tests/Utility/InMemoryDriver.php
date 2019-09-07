<?php

namespace ZebraTests\Utility;

use mysqli;
use PDO;
use Zebra\DatabaseDriver\PDODriver;

/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 06.09.19
 * Time: 21:38
 */
class InMemoryDriver extends PDODriver
{
    public function __construct()
    {
        parent::__construct(new PDO("sqlite::memory:"));
    }
}