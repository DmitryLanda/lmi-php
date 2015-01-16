<?php
/*
* Copyright © FarHeap Solutions
*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Controller;

use LmiSchool\Core\AuthService;

/**
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class LoginController extends AbstractController
{
    public function loginAction()
    {
        $error = false;
        if ($this->request->isPost()) {
            $authService = AuthService::getInstance();
            $this->authData = $authService->login(
                $this->request->get('username'),
                $this->request->get('password')
            );

            if ($this->authData->isValid()) {
                $this->redirectTo('home');
            } else {
                $error = true;
            }
        }

        $this->render('Login/login.html.twig', ['error' => $error]);
    }

    public function logoutAction()
    {
        AuthService::getInstance()->logout();

        $this->redirectTo('home');
    }
}
