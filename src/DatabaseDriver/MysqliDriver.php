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
        return mysqli_query($this->db, 'LOCK TABLE `' . $tableName . '` WRITE') !== false;
    }

    /**
     * Unlock all tables.
     * @return bool
     */
    public function unlockAllTables()
    {
        return mysqli_query($this->db, 'UNLOCK TABLES') !== false;
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
        $sql = 'UPDATE ' . $tableName . ' ' . $this->getSetsSql($sets) . ' ' . $this->getConditionsSql($conditions);
        return mysqli_query($this->db, $sql) !== false;
    }

    /**
     * Returns sql part of SET at UPDATE.
     * TODO: column escaping
     * @param array $sets
     * @return string
     */
    private function getSetsSql($sets)
    {
        $sql = 'SET ';
        foreach ($sets as $name => $value) {
            $sql .= ' ' . $name . ' = ' . $value . ',';
        }
        return rtrim($sql, ',');
    }

    /**
     * Returns sql part of WHERE
     * TODO: column escaping
     * @param array $conditions
     * @return bool|string
     */
    private function getConditionsSql(array $conditions)
    {
        if (count($conditions) == 0) {
            return '';
        }
        $conditionsWithOperators = $this->splitConditions($conditions);
        $sql = 'WHERE';
        foreach ($conditionsWithOperators as $contition) {
            $sql .= ' ' . $contition[0] . ' ' . $contition[1] . ' ' . $contition[2] . ' AND';
        }
        return substr($sql, 0, -3); //skip last AND
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
        $columnsString = '`' . implode('`,`', $columns) . '`';
        $valueString = '"' . implode('","', $values) . '"';
        $sql = 'INSERT INTO ' . $tableName . ' (' . $columnsString . ') VALUES (' . $valueString . ')';
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
        $sql = "DELETE FROM " . $tableName . ' ' . $this->getConditionsSql($conditions);
        return mysqli_query($this->db, $sql) !== false;
    }

    /**
     * Select data from table.
     * @param array $selectedColumns
     * @param array $tableName
     * @param array $conditions
     * @param array $orderBy
     * @return mixed
     */
    public function select($selectedColumns, $tableName, $conditions, $orderBy)
    {
        $select = '*';
        if (count($selectedColumns)) {
            $select = implode(',', $selectedColumns);
        }
        $conditionsString = $this->getConditionsSql($conditions);
        $orderByString = '';
        if (count($orderBy)){
            $orderByString = 'ORDER BY '.implode(',',$orderBy);
        }
        $sql = 'SELECT '.$select.' FROM '.$tableName.' '.$conditionsString.' '.$orderByString;
        return new MysqliResult(mysqli_query($this->db, $sql));
    }
}