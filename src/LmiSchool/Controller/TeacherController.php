<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Controller;
use LmiSchool\Core\Config;
use LmiSchool\Model\Teacher;

/**
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class TeacherController extends AbstractController
{
    public function listAction()
    {
        $perPage = Config::getInstance()->get('pagination.teachers.per_page');
        $page = $this->getPage();
        $offset = ($page - 1) * $perPage;

        $sortName = $this->request->get('sort_name', 'teacher_name');
        $sortOrder = $this->request->get('sort_order', 'ASC');

        $searchKey = $this->request->get('search_key');
        $searchValue = $this->request->get('search_value');

        $search = [];
        if ($searchKey && $searchValue) {
            $search = [$searchKey => $searchValue];
        }

        $teachers = Teacher::findBy($search, [$sortName => $sortOrder], $perPage, $offset);

        $this->render('Teacher/list.html.twig', [
            'teachers' => $teachers,
            'page' => $page,
            'perPage' => $perPage
        ]);
    }

    public function showAction()
    {
        $teacher = Teacher::find($this->request->get('id'));

        $this->render('Teacher/show.html.twig', ['teacher' => $teacher]);
    }
}
