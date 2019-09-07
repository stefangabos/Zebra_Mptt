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
class InMemoryDriver extends PDODriver implements DatabaseHelperMethods
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO("sqlite::memory:");
        parent::__construct($this->db);
    }

    public function tableExists(string $tableName):bool
    {
        try {
            $result = $this->db->query("SELECT 1 FROM {$tableName} LIMIT 1");
        } catch (\PDOException $e) {
            return FALSE;
        }

        return $result !== FALSE;
    }

    public function close()
    {
        $this->db = null;
        parent::close();
    }

}