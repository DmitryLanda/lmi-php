<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Controller;
use LmiSchool\Core\Config;
use LmiSchool\Model\Document;

/**
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class DocumentController extends AbstractController
{
    public function listAction()
    {
        $perPage = Config::getInstance()->get('pagination.documents.per_page');
        $pageCount = ceil(Document::count() / $perPage);
        $page = $this->getPage($pageCount);
        $offset = ($page - 1) * $perPage;
        $documents = Document::findBy([], ['doc_name' => 'ASC'], $perPage, $offset);
        $this->render('Document/list.html.twig', [
            'documents' => $documents,
            'documentsPagesCount' => $pageCount,
            'page' => $page
        ]);
    }

    public function showAction()
    {
        $this->render('Document/show.html.twig');
    }
}
