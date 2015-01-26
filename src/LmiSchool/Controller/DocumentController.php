<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Controller;
use LmiSchool\Core\Config;
use LmiSchool\Model\Document;

/**
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
 */
class DocumentController extends AbstractController
{
    public function listAction()
    {
        $perPage = Config::getInstance()->get('pagination.documents.per_page');
        $page = $this->getPage();
        $offset = ($page - 1) * $perPage;

        $sortName = $this->request->get('sort_name', 'doc_name');
        $sortOrder = $this->request->get('sort_order', 'ASC');

        $searchKey = $this->request->get('search_key');
        $searchValue = $this->request->get('search_value');

        $search = [];
        if ($searchKey && $searchValue) {
            $search = [$searchKey => $searchValue];
        }

        $documents = Document::findBy($search, [$sortName => $sortOrder], $perPage, $offset);
        $this->render('Document/list.html.twig', [
            'documents' => $documents,
            'perPage' => $perPage,
            'page' => $page
        ]);
    }

    public function showAction()
    {
        $this->render('Document/show.html.twig');
    }

    public function downloadAction()
    {
        $id = $this->request->get('id');
        if (!$id) {
            $this->renderNotFound();
        }

        /** @var Document $document */
        $document = Document::find($id);
        if (!$document) {
            $this->renderNotFound();
        }

        var_dump($document->getUrlToView(), $document->getUrlToDownload());
    }
}
