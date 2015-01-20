<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Controller;

/**
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class IndexController extends AbstractController
{
    public function indexAction()
    {
        $this->redirectTo('news.list');
    }
}
