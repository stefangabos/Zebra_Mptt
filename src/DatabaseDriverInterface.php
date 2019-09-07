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
     * Returns description of last error
     * @return string
     */
    public function getErrorInfo();
}