<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 07.09.19
 * Time: 16:09
 */

namespace Zebra\DatabaseDriver;


use Zebra\AbstractDatabaseDriver;

abstract class AbstractSqlDriver extends AbstractDatabaseDriver
{
    /**
     * Returns sql part of SET at UPDATE.
     * TODO: column escaping
     * @param array $sets
     * @return string
     */
    protected function getSetsSql($sets)
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
    protected function getConditionsSql(array $conditions)
    {
        if (count($conditions) == 0) {
            return '';
        }
        $conditionsWithOperators = $this->splitConditions($conditions);
        $sql = 'WHERE';
        foreach ($conditionsWithOperators as $condition) {
            $sql .= ' ' . $condition[0] . ' ' . $condition[1] . ' ' . $condition[2] . ' AND';
        }
        return substr($sql, 0, -3); //skip last AND
    }

    /**
     * @param $tableName
     * @return string
     */
    protected function getQueryLockTableForWrite($tableName)
    {
        return 'LOCK TABLE `' . $tableName . '` WRITE';
    }

    /**
     * @return string
     */
    protected function getQueryUnlockAllTables()
    {
        return 'UNLOCK TABLES';
    }

    /**
     * @param string $tableName
     * @param array $sets
     * @param array $conditions
     * @return string
     */
    protected function getQueryUpdate($tableName, $sets, $conditions)
    {
        return 'UPDATE ' . $tableName . ' ' . $this->getSetsSql($sets) . ' ' . $this->getConditionsSql($conditions);
    }

    /**
     * @param string $tableName
     * @param array $columns
     * @param array $values
     * @return string
     */
    protected function getQueryInsert($tableName, $columns, $values)
    {
        $columnsString = '`' . implode('`,`', $columns) . '`';
        $valueString = '"' . implode('","', $values) . '"';
        return 'INSERT INTO ' . $tableName . ' (' . $columnsString . ') VALUES (' . $valueString . ')';
    }

    /**
     * @param string $tableName
     * @param array $conditions
     * @return string
     */
    protected function getQueryDelete($tableName, $conditions)
    {
        return "DELETE FROM " . $tableName . ' ' . $this->getConditionsSql($conditions);
    }

    /**
     * @param array $selectedColumns
     * @param string $tableName
     * @param array $conditions
     * @param array $orderBy
     * @return string
     */
    protected function getQuerySelect($selectedColumns, $tableName, $conditions, $orderBy)
    {
        $select = '*';
        if (count($selectedColumns)) {
            $select = implode(',', $selectedColumns);
        }
        $conditionsString = $this->getConditionsSql($conditions);
        $orderByString = '';
        if (count($orderBy)) {
            $orderByString = 'ORDER BY ' . implode(',', $orderBy);
        }
        return 'SELECT ' . $select . ' FROM ' . $tableName . ' ' . $conditionsString . ' ' . $orderByString;
    }
}