<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 07.09.19
 * Time: 14:06
 */

namespace Zebra\Mptt;


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
                return [$operator,$length];
            }
        }
        return ['=',0]; //default operator
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
            $operatorDesc = $this->detectOperator($trimmedName);
            $columnName = $operatorDesc[1] == 0 ? $trimmedName : substr($trimmedName,0,$operatorDesc[1]);
            $output[] = array(trim($columnName),$operatorDesc[0],$value);
        }
        return $output;
    }
}