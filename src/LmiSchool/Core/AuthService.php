<?php
/*
* Copyright © FarHeap Solutions
*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Core;
use Aura\Auth\Auth;
use Aura\Auth\AuthFactory;
use Exception;

/**
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class AuthService
{
    private $auth;
    private $loginService;
    private $logoutService;
    private $resumeService;
    private static $instance;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $username
     * @param string $password
     * @return Auth
     */
    public function login($username, $password)
    {
        try {
            $this->loginService->login($this->auth, [
                'username' => $username,
                'password' => $password
            ]);
        } catch (Exception $e) {
            //log it
        }

        return $this->auth;
    }

    public function logout(){
        $this->logoutService->logout($this->auth);
    }

    /**
     * @return Auth
     */
    public function resume()
    {
        $this->resumeService->resume($this->auth);

        return $this->auth;
    }

    private function __construct()
    {
        $pathToPasswordFile = __DIR__ . '/../../../web/.htpasswd';
        $authFactory = new AuthFactory($_COOKIE);
        $adapter = $authFactory->newHtpasswdAdapter($pathToPasswordFile);
        $this->loginService = $authFactory->newLoginService($adapter);
        $this->logoutService = $authFactory->newLogoutService($adapter);
        $this->resumeService = $authFactory->newResumeService($adapter);
        $this->auth = $authFactory->newInstance();
    }

    private function __sleep() {}
    private function __wakeup() {}
    private function __clone() {}
}
