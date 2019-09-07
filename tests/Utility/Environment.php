<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 06.09.19
 * Time: 22:30
 */

namespace ZebraTests\Mptt\Utility;


class Environment
{
    public static function getInstallFileContent(): string
    {
        $content = file_get_contents(static::getInstallFilePath());
        $content = static::removeMysqlPart($content);
        return rtrim(trim($content), ';');
    }

    public static function getInstallFilePath(): string
    {
        return realpath(__DIR__ . '/../../install/mptt.sql');
    }

    private static function removeMysqlPart($content)
    {
        $replacement = [
            ' ENGINE=InnoDB DEFAULT CHARSET=utf8' => '',
            'auto_increment' => ''
        ];
        return str_replace(array_keys($replacement), array_values($replacement), $content);
    }
}