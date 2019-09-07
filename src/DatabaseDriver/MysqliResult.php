<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 07.09.19
 * Time: 15:53
 */

namespace Zebra\DatabaseDriver;


use Zebra\AbstractResult;

class MysqliResult extends AbstractResult
{
    /**
     * @var \mysqli_result
     */
    private $result;

    /**
     * MysqliResult constructor.
     * @param \mysqli_result $mysqliResult
     */
    function __construct($mysqliResult)
    {
        $this->result = $mysqliResult;
    }

    /**
     * Fetch row.
     * @return array
     */
    public function fetchAssoc()
    {
        return mysqli_fetch_assoc($this->result);
    }
}