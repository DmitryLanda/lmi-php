<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Controller;
use LmiSchool\Model\Exception\ModelException;
use LmiSchool\Model\Page;

/**
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class PageController extends AbstractController
{
    public function showAction()
    {
        $path = $this->getPagePath();
        $page = Page::findOneBy(['slug' => $path]);

        if (!$page) {
            $this->redirectTo('error.not_found');
        }

        $this->render('Page/show.html.twig', ['page' => $page]);
    }

    public function editAction()
    {
        $this->checkCredentials();

        $id = $this->request->get('id');
        $page = Page::findOneBy(['id' => $id]);

        if (!$page) {
            $this->redirectTo('error.not_found');
        }

        $this->render('Page/edit.html.twig', ['page' => $page]);
    }

    public function updateAction()
    {
        $this->checkCredentials();

        $id = $this->request->get('id');
        $page = Page::findOneBy(['id' => $id]);

        if (!$page) {
            $page = new Page();
        }

        $this->fillPageFromRequest($page);

        try {
            $page->save();
        } catch (ModelException $e) {
            http_response_code(409);
            echo $e->getMessage();
            exit;
        }

        echo 'OK';
    }

    public function listAction()
    {
        $this->checkCredentials();

        $result = [];
        $pages = Page::findBy([], ['slug' => 'ASC']);
        foreach ($pages as $page) {
            $offset = strpos($page->getSlug(), '/');
            $key = substr($page->getSlug(), 0, $offset);
            $offset = $offset === false ? 0 : $offset + 1;
            $result[$key][substr($page->getSlug(), $offset)] = $page;
        }
        ksort($result);

        $this->render('Page/list.html.twig', [
            'pages' => $result
        ]);
    }

    public function addAction()
    {
        $this->checkCredentials();

        $page = new Page();

        if ($this->request) {
            $this->fillPageFromRequest($page);

            try {
                $page->save();
                $page = Page::findOneBy(['slug' => $page->getSlug()]);
                $this->redirectTo('admin.page.edit', ['id' => $page->getId()]);
            } catch (ModelException $e) {
                //need to log and add session flash messages
            }
        }

        $this->render('Page/edit.html.twig', ['page' => $page]);
    }

    /**
     * @return string
     */
    private function getPagePath()
    {
        $slug = $this->request->get('slug');
        $slugs = $this->request->get('slugs');
        $path = implode('/', array_merge([$slug], $slugs));

        if (!$path) {
            $this->redirectTo('error.not_found');
        }

        return $path;
    }

    /**
     * @param Page $page
     */
    private function fillPageFromRequest(Page $page)
    {
        $page->setSlug($this->request->get('new_slug'))
            ->setTitle($this->request->get('title'))
            ->setContent($this->request->get('content'))
            ->setTags($this->request->get('tags'));
    }
}
