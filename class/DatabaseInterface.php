<?php
/**
 * Created by PhpStorm.
 * User: nicop
 * Date: 01/07/16
 * Time: 00:37
 */

namespace Recipy\Db;

interface DatabaseInterface
{
    public function prepare($statement, $driver_options);
}