<?php

namespace Recipy\Db;

use Symfony\Component\Yaml\Parser;

/**
 * Class databaseAbstract
 */
class DatabaseAbstract extends SafePDO implements DatabaseInterface
{
    public function __construct()
    {
        $yaml = new Parser();
        $db = $yaml->parse(file_get_contents(CONF_PATH . 'config.yml'))['db'];
        $db['name'] = 'mysql:dbname=' . $db['name'] .';host='.$db['host'].':'.$db['port'];
        $driver_options = array();
        parent::__construct($db['name'], $db['username'], $db['pwd'], $driver_options);
    }

    /**
     * @param string $statement
     * @param array  $driver_options
     *
     * @return \PDOStatement
     */
    public function prepare($statement, $driver_options = null)
    {
        if($driver_options === null)
            $driver_options = [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY];
        return parent::prepare($statement, $driver_options);
    }
}