<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 07.09.19
 * Time: 16:29
 */

namespace ZebraTests\Mptt\Utility;


interface DatabaseHelperMethods
{
    public function tableExists(string $tableName):bool;
}