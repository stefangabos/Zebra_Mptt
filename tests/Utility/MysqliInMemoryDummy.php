<?php

namespace ZebraTests\Utility;

use mysqli;
use PDO;

/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 06.09.19
 * Time: 21:38
 */
class MysqliInMemoryDummy implements DatabaseStubHelpMethodsInterface, MysqliInterface
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO("sqlite::memory:");
    }

    public function close()
    {
        $this->db = null;
    }


    public function query(string $query)
    {
        $return = $this->db->query($query)->execute();
    }

    public function tableExists($tableName)
    {
        try {
            $query = $this->db->query("SELECT name FROM sqlite_master WHERE type ='table' AND name NOT LIKE 'sqlite_%'");
            if (!$query){
                return false;
            }
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return false;
        }
        $names = array_map(function($item){ return $item['name'];},$result);
        return in_array($tableName, $names);
    }
}