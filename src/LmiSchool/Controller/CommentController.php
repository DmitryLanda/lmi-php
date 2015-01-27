<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Controller;

use InvalidArgumentException;
use LmiSchool\Core\Config;
use LmiSchool\Model\Comment;
use LmiSchool\Model\Exception\ModelException;

/**
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
 */
class CommentController extends AbstractController
{
    public function listAction()
    {
        $perPage = Config::getInstance()->get('pagination.comments.per_page');
        $page = $this->getPage();
        $offset = ($page - 1) * $perPage;

        $sortName = $this->request->get('sort_name', 'date');
        $sortOrder = $this->request->get('sort_order', 'DESC');

        $searchKey = $this->request->get('search_key');
        $searchValue = $this->request->get('search_value');

        $search = [];
        if ($searchKey && $searchValue) {
            $search = [$searchKey => $searchValue];
        }

        $comments = Comment::findBy($search, [$sortName => $sortOrder], $perPage, $offset);
        $this->render('Comment/list.html.twig', [
            'comments' => $comments,
            'perPage' => $perPage,
            'page' => $page
        ]);
    }

    public function addAction()
    {
        $error = null;
        $comment = new Comment();
        if ($this->request->isPost()) {
            try {
                $comment->setAuthor($this->request->get('author'))
                    ->setEmail($this->request->get('email'))
                    ->setCity($this->request->get('address'))
                    ->setMessage($this->request->get('message'));

                $this->validate();

                $comment->save();
                $this->redirectTo('comments.list', ['options' => ['page'=> 1]]);
            } catch (InvalidArgumentException $e) {
                $error = $e->getMessage();
            } catch (ModelException $e) {
                $error = 'При сохранении возникла ошибка.';
            }
        }

        $this->render('Comment/add.html.twig', ['comment' => $comment, 'error' => $error]);
    }

    /**
     * @return boolean
     * @throws InvalidArgumentException
     */
    private function validate()
    {
        if (!$this->request->get('check')) {
            throw new InvalidArgumentException('Введите код подтверждения');
        }
        if ($this->request->get('check') !== $_SESSION['lmi.comments.captcha']) {
            throw new InvalidArgumentException('Неверный код подтверждения');
        }

        if (!$this->request->get('message')) {
            throw new InvalidArgumentException('Введите текст сообщения');
        }

        if (!$this->request->get('author')) {
            throw new InvalidArgumentException('Введите имя');
        }

        return true;
    }

    public function getCaptchaAction()
    {
        $_SESSION['lmi.comments.captcha'] = substr(sha1(uniqid('', true)), -6, 6);

        $img = imagecreatetruecolor(120, 35);
        $bgColor = imagecolorallocate($img, 80, 80, 80);
        $fontColor = imagecolorallocate($img, 0, 0, 0);
        imagefilledrectangle($img, 0, 0, 120, 35, $bgColor);

        $text = $_SESSION['lmi.comments.captcha'];
        $font = __DIR__ . '/../../../web/assets/fonts/dejavu.ttf';

        imagettftext($img, 20, 180, 110, 10, $fontColor, $font, $text);

        header('Content-Type: image/png');
        imagepng($img);

        imagedestroy($img);
    }
}
