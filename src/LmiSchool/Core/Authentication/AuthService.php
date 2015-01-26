<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Core\Authentication;
use Aura\Auth\Auth;
use Aura\Auth\AuthFactory;
use Aura\Auth\Verifier\PasswordVerifier;
use Exception;
use LmiSchool\Core\DatabaseConnection;

/**
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
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
        $authFactory = new AuthFactory($_COOKIE);
        $adapter = new DBALAdapter(
            DatabaseConnection::getConnection(),
            new PasswordVerifier(PASSWORD_BCRYPT),
            [
                'u.user',
                'u.hash',
                't
                .id',
                't.teacher_name',
                't.teacher_foto'
            ],
            'users u JOIN teachers t ON t.teacher_id = u.teacher_id'
        );
        $this->loginService = $authFactory->newLoginService($adapter);
        $this->logoutService = $authFactory->newLogoutService($adapter);
        $this->resumeService = $authFactory->newResumeService($adapter);
        $this->auth = $authFactory->newInstance();
    }

    private function __sleep() {}
    private function __wakeup() {}
    private function __clone() {}
}
