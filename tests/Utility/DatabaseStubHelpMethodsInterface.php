<?php

namespace ZebraTests\Utility;
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 06.09.19
 * Time: 21:40
 */

interface DatabaseStubHelpMethodsInterface
{
    public function close();

    public function tableExists($string);
}