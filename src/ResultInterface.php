<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 07.09.19
 * Time: 15:52
 */

namespace Zebra;


interface ResultInterface
{

    /**
     * Fetch row.
     * @return array
     */
    public function fetchAssoc();
}