<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 06.09.19
 * Time: 22:04
 */

namespace ZebraTests\Utility;


interface MysqliInterface
{
    public function query(string $query);
}