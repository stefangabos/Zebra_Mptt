<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 06.09.19
 * Time: 23:11
 */

namespace Zebra\DatabaseDriver;

use Zebra\AbstractDatabaseDriver;

class MysqliDriver extends AbstractDatabaseDriver
{
    /**
     * @var \mysqli
     */
    private $db;

    public function __construct($mysqliLink)
    {
        // stop if the mysqli extension is not loaded
        if (!extension_loaded('mysqli')) {
            trigger_error('mysqli extension is required', E_USER_ERROR);
        }

        if (!$mysqliLink instanceof \mysqli){
            trigger_error('provided link should be mysqli connection', E_USER_ERROR);
        }

        $this->db = $mysqliLink;
    }

    /**
     * Checks that database is connected.
     * @return bool
     */
    public function isConnected()
    {
        return @mysqli_ping($this->db);
    }
}