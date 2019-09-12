<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 06.09.19
 * Time: 23:11
 */

namespace Zebra\Mptt\DatabaseDriver;

use Zebra\Mptt\AbstractDatabaseDriver;
use Zebra\Mptt\ResultInterface;

class MysqliDriver extends AbstractSqlDriver
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

        if (!$mysqliLink instanceof \mysqli) {
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

    /**
     * Returns description of last error.
     * @return string
     */
    public function getErrorInfo()
    {
        return mysqli_error($this->db);
    }

    /**
     * Locks the table for write operation.
     * TODO: other types?
     * @param string $tableName
     * @return bool
     */
    public function lockTableForWrite($tableName)
    {
        return mysqli_query($this->db, $this->getQueryLockTableForWrite($tableName)) !== false;
    }

    /**
     * Unlock all tables.
     * @return bool
     */
    public function unlockAllTables()
    {
        return mysqli_query($this->db, $this->getQueryUnlockAllTables()) !== false;
    }

    /**
     * Updates data in table.
     * @param string $tableName
     * @param array $sets
     * @param array $conditions
     * @return bool
     */
    public function update($tableName, $sets, $conditions)
    {
        $sql = $this->getQueryToUpdate($tableName,$sets,$conditions);
        return mysqli_query($this->db, $sql) !== false;
    }


    /**
     * mysqli_real_escape_string
     * @param string $string
     * @return string
     */
    public function escape($string)
    {
        return mysqli_real_escape_string($string);
    }

    /**
     * Insert row to the table.
     * @param string $tableName
     * @param array $columns
     * @param array $values
     * @return bool
     */
    public function insert($tableName, $columns, $values)
    {
        $sql = $this->getQueryInsert($tableName, $columns, $values);
        return mysqli_query($this->db, $sql) !== false;
    }

    /**
     * Get last insert id
     * @return int
     */
    public function getLastInsertId()
    {
        return mysqli_insert_id($this->db);
    }

    /**
     * @param string $tableName
     * @param array $conditions
     * @return bool
     */
    public function delete($tableName, $conditions)
    {
        $sql = $this->getQueryDelete($tableName, $conditions);
        return mysqli_query($this->db, $sql) !== false;
    }

    /**
     * Select data from table.
     * @param array $selectedColumns
     * @param string $tableName
     * @param array $conditions
     * @param array $orderBy
     * @return mixed
     */
    public function select($selectedColumns, $tableName, $conditions, $orderBy)
    {
        $sql = $this->getQuerySelect($selectedColumns,$tableName,$conditions,$orderBy);
        return $this->query($sql);
    }


    /**
     * Close connection.
     */
    public function close()
    {
        $this->db = null;
    }

    /**
     * @param string $query
     * @return ResultInterface
     */
    public function query($query)
    {
        return new MysqliResult(mysqli_query($this->db,$query));
    }
}