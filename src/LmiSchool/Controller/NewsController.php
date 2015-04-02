<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Controller;
use LmiSchool\Core\Config;
use LmiSchool\Model\News;

/**
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
 */
class NewsController extends AbstractController
{
    public function listAction()
    {
        $perPage = Config::getInstance()->get('pagination.news.per_page');
        $page = $this->getPage();
        $offset = ($page - 1) * $perPage;

        $sortName = $this->request->get('sort_name', 'date_up');
        $sortOrder = $this->request->get('sort_order', 'DESC');

        $searchKey = $this->request->get('search_key');
        $searchValue = $this->request->get('search_value');

        $search = [];
        if ($searchKey && $searchValue) {
            $search = [$searchKey => $searchValue];
        }

        $news = News::findBy($search, [$sortName => $sortOrder], $perPage, $offset);
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

    public function removeAction()
    {
        $id = $this->request->get('id');
        if ($news = News::find($id)) {
            $news->remove();
        }

        $this->redirectTo('news.list');
    }
}
