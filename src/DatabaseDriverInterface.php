<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 07.09.19
 * Time: 14:06
 */

namespace Zebra;


interface DatabaseDriverInterface
{
    /**
     * Checks that database is connected.
     * @return bool
     */
    public function isConnected();

    /**
     * Returns description of last error.
     * @return string
     */
    public function getErrorInfo();

    /**
     * Locks the table for write operation.
     * TODO: other types?
     * @param string $table_name
     * @return bool
     */
    public function lockTableForWrite($table_name);

    /**
     * Unlock all tables.
     * @return bool
     */
    public function unlockAllTables();

    /**
     * Updates data in table.
     * @param string $tableName
     * @param array $sets
     * @param array $conditions
     * @return bool
     */
    public function update($tableName,/* array*/ $sets,/* array*/ $conditions);

    /**
     * mysqli_real_escape_string
     * @param string $string
     * @return string
     */
    public function escape($string);

    /**
     * Insert row to the table.
     * @param string $tableName
     * @param array $columns
     * @param array $values
     * @return bool
     */
    public function insert($tableName, $columns, $values);

    /**
     * Get last insert id
     * @return int
     */
    public function getLastInsertId();

    /**
     * @param string $tableName
     * @param array $conditions
     * @return bool
     */
    public function delete($tableName, $conditions);
}