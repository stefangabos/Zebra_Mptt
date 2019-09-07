<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 07.09.19
 * Time: 15:58
 */

namespace Zebra\DatabaseDriver;


use PDO;
use PDOException;
use Zebra\AbstractDatabaseDriver;
use Zebra\ResultInterface;

class PDODriver extends AbstractSqlDriver
{

    /**
     * @var \PDO
     */
    private $db;

    public function __construct($pdoLink)
    {
        // stop if the mysqli extension is not loaded
        if (!extension_loaded('pdo')) {
            trigger_error('pdo extension is required', E_USER_ERROR);
        }

        if (!$pdoLink instanceof PDO) {
            trigger_error('provided link should be pdo connection', E_USER_ERROR);
        }

        $this->db = $pdoLink;
    }

    /**
     * Checks that database is connected.
     * @return bool
     */
    public function isConnected()
    {
        try {
            $this->db->query('SELECT 1');
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    /**
     * Returns description of last error.
     * @return string
     */
    public function getErrorInfo()
    {
        return implode('|',$this->db->errorInfo());
    }

    /**
     * Locks the table for write operation.
     * TODO: other types?
     * @param string $tableName
     * @return bool
     */
    public function lockTableForWrite($tableName)
    {
        return $this->db->exec($this->getQueryLockTableForWrite($tableName))>0;
    }

    /**
     * Unlock all tables.
     * @return bool
     */
    public function unlockAllTables()
    {
        return $this->db->exec($this->getQueryUnlockAllTables())>0;
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
        $sql = $this->getQueryUpdate($tableName,$sets,$conditions);
        return $this->exec($sql);
    }

    /**
     * mysqli_real_escape_string
     * @param string $string
     * @return string
     */
    public function escape($string)
    {
        return $this->db->quote($string);
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
        return $this->exec($sql);
    }

    /**
     * Get last insert id
     * @return int
     */
    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * @param string $tableName
     * @param array $conditions
     * @return bool
     */
    public function delete($tableName, $conditions)
    {
        $sql = $this->delete($tableName, $conditions);
        return $this->db->exec($sql) > 0;
    }

    /**
     * Select data from table.
     * @param array $selectedColumns
     * @param string $tableName
     * @param array $conditions
     * @param array $orderBy
     * @return ResultInterface
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
        return new PDOResult($this->db->query($query));
    }

    /**
     * Safe execute.
     * @param $sql
     * @return bool
     */
    private function exec($sql)
    {
        try {
            $this->db->exec($sql);
        }catch(PDOException $e){
            return false;
        }
        return true;
    }
}