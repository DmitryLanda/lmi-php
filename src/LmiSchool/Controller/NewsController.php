<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Controller;
use LmiSchool\Core\Config;
use LmiSchool\Model\News;

/**
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class NewsController extends AbstractController
{
    public function listAction()
    {
        $perPage = Config::getInstance()->get('pagination.news.per_page');
        $page = $this->getPage();
        $offset = ($page - 1) * $perPage;
        $news = News::findBy([], ['date_up' => 'DESC', 'id' => 'DESC'], $perPage, $offset);
        $this->render('News/list.html.twig', [
            'newsList' => $news,
            'videoList' => [],
            'perPage' => $perPage,
            'page' => $page
        ]);
    }

    public function showAction()
    {
        $news = News::find($this->request->get('id'));

        $this->render('News/show.html.twig', ['news' => $news]);
    }
}
