<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 07.09.19
 * Time: 14:06
 */

namespace Zebra;


abstract class AbstractDatabaseDriver implements DatabaseDriverInterface
{
    /**
     * Detects operator at table of conditions (actually left sides of items).
     * Operators should be common for all drivers.
     * @param string $name
     * @return string
     */
    private function detectOperator($name)
    {
        static $operators = ['>'=>-1,'<'=>-1,'>='=>-2,'<='=>-2,'LIKE'=>-4]; // 'operator'=>-1*strlen('operator')
        foreach($operators as $operator=>$length){
            if (substr($name,$length) == $operator){
                return $operator;
            }
        }
        return '='; //default operator
    }

    /**
     * Split conditions to name, operator, value.
     * This should be common for all drivers.
     *
     * TODO: more complex condtions f.e. 'OR'=>[...]
     *
     * @param array &$conditions
     * @return array
     */
    protected function splitConditions(&$conditions){
        $output = array();
        foreach($conditions as $name=>$value){
            $trimmedName = trim($name);
            $operator = $this->detectOperator($trimmedName);
            $columnName = substr($trimmedName,0,-1*strlen($operator));
            $output[] = array($columnName,$operator,$value);
        }
        return $output;
    }
}