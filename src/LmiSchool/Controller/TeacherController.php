<?php
/*
* Copyright © FarHeap Solutions
*
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
        $pageCount = ceil(Teacher::count() / $perPage);
        $page = $this->getPage($pageCount);
        $offset = ($page - 1) * $perPage;
        $teachers = Teacher::findBy([], ['teacher_name' => 'ASC'], $perPage, $offset);
        $this->render('Teacher/list.html.twig', [
            'teachers' => $teachers,
            'teachersPagesCount' => $pageCount,
            'page' => $page
        ]);
    }

    public function showAction()
    {
        $teacher = Teacher::find($this->request->get('id'));

        $this->render('Teacher/show.html.twig', ['teacher' => $teacher]);
    }
}
