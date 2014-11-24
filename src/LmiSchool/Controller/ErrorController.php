<?php
/*
* Copyright © FarHeap Solutions
*
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
        $this->render('Error/404.html.twig');
    }
}
