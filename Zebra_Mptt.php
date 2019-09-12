<?php


use Zebra\Mptt\DatabaseDriver\MysqliDriver;
use Zebra\Mptt\Mptt;

/**
 * Class Zebra_Mptt
 * Compatibility class
 */
class Zebra_Mptt extends Mptt{

    /**
     * Zebra_Mptt constructor.
     * @param resource $link
     * @param string $table_name
     * @param string $id_column
     * @param string $title_column
     * @param string $left_column
     * @param string $right_column
     * @param string $parent_column
     */
    public function __construct(&$link, $table_name = 'mptt', $id_column = 'id', $title_column = 'title', $left_column = 'lft', $right_column = 'rgt', $parent_column = 'parent')
    {
        $connection = new MysqliDriver($link);
        parent::__construct($connection, $table_name, $id_column, $title_column, $left_column, $right_column, $parent_column);
    }
}