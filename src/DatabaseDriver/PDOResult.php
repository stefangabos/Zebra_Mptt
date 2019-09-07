<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 07.09.19
 * Time: 15:58
 */

namespace Zebra\DatabaseDriver;


use Zebra\ResultInterface;

class PDOResult implements ResultInterface
{
    private $result;

    /**
     * PDOResult constructor.
     * @param \PDOStatement $pdoResult
     */
    function __construct($pdoResult)
    {
        $this->result = $pdoResult;
    }

    /**
     * Fetch row.
     * @return array
     */
    public function fetchAssoc()
    {
        return $this->result->fetch();
    }
}