<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Core;

use Yandex\Disk\DiskClient;

/**
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
 */
class YandexDiskClient
{
    /**
     * @var DiskClient
     */
    private static $client;

    /**
     * @return DiskClient
     */
    public static function getInstance()
    {
        if (!self::$client) {
            self::$client = new DiskClient(self::getToken());
        }

        return self::$client;
    }

    /**
     * @return string
     */
    private static function getToken()
    {
        $token = Config::getInstance()->get('yandex-disk.token');
        if (!$token) {
            $token = getenv('YANDEX_DISC_ACCESS_TOKEN');
        }

        return $token;
    }

    private function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
}
