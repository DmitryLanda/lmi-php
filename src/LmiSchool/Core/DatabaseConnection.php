<?php
/*
* Copyright © FarHeap Solutions
*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

/**
 * Class DatabaseConnection
 *
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class DatabaseConnection
{
    /**
     * @var Connection
     */
    private static $connection;

    /**
     * @return Connection
     */
    public final static function getConnection()
    {
        if (!self::$connection) {
            self::connect();
        }

        return self::$connection;
    }


    private static function connect()
    {
        $config = Config::getInstance();

        self::$connection =  DriverManager::getConnection(array(
            'dbname' => $config->get('database.name'),
            'user' => $config->get('database.user'),
            'password' => $config->get('database.password'),
            'host' => $config->get('database.host'),
            'driver' => $config->get('database.driver'),
            'charset' => $config->get('database.charset'),
        ));
    }

    private function __construct() {}

    private function __clone() {}

    private function __sleep() {}

    private function __wakeup() {}
}
