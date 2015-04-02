<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;

/**
 * Class DatabaseConnection
 *
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
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

    /**
     * @throws DBALException
     */
    private static function connect()
    {
        $config = Config::getInstance();
        $configuredConnectionData = array(
            'dbname' => $config->get('database.name'),
            'user' => $config->get('database.user'),
            'password' => $config->get('database.password'),
            'host' => $config->get('database.host'),
            'driver' => $config->get('database.driver'),
            'charset' => $config->get('database.charset'),
        );
        $environmentConnectionData = self::parseGlobalConfigVar();
        $connectionData = array_replace($configuredConnectionData, $environmentConnectionData);

        self::$connection =  DriverManager::getConnection($connectionData);
    }

    /**
     * @return array
     */
    private static function parseGlobalConfigVar()
    {
        $connectionString = getenv('CLEARDB_DATABASE_URL');
        $connectionData = [];

        if ($connectionString) {
            $parsedData = parse_url($connectionString);
            $connectionData['dbname'] = ltrim($parsedData['path'], "/");
            $connectionData['user'] = $parsedData['user'];
            $connectionData['password'] = $parsedData['pass'];
            $connectionData['host'] = $parsedData['host'];
        }

        return $connectionData;
    }

    private function __construct() {}

    private function __clone() {}

    private function __sleep() {}

    private function __wakeup() {}
}
