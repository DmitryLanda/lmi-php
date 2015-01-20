<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Controller;

/**
 * Class ErrorController
 *
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class ErrorController extends AbstractController
{
    public function notFoundAction()
    {
        http_response_code(404);
        $this->render('Error/404.html.twig');
    }

    public function notAuthorizedAction()
    {
        http_response_code(403);
        $this->render('Error/403.html.twig');
    }
}
