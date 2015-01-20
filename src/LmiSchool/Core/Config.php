<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Core;

use InvalidArgumentException;

/**
 * Class Config
 *
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class Config
{
    /**
     * @var Config
     */
    private static $instance;

    /**
     * @var array
     */
    private $parameterBag = array();

    /**
     * @return Config
     */
    public final static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct($pathToConfigFile = null)
    {
        $pathToConfigFile = $pathToConfigFile ?: __DIR__ . '/../Resources/config.json';

        $this->parameterBag = json_decode(file_get_contents($pathToConfigFile), true);
    }

    /**
     * @param string $key
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function get($key)
    {
        $tokens = explode('.', $key);
        $container = $this->parameterBag;
        foreach ($tokens as $token) {
            if (!array_key_exists($token, $container)) {
                throw new InvalidArgumentException(sprintf('There is no "%s" option configured yet', $key));
            }

            $container = $container[$token];
        }



        return $container;
    }

    private function __clone() {}

    private function __sleep() {}

    private function __wakeup() {}
}
