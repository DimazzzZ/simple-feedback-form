<?php

/**
 * Project: simple-feedback-form
 * Date: 06.05.16
 * Time: 21:09
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license GPL-3.0
 * @link    http://artlark.ru/
 */

namespace Controllers;

use App;
use Models\Comment as CommentModel;
use View;

class Comment extends Generic
{
    public function indexAction()
    {
        $comments = new CommentModel;

        $order = $this->request->getQuery('order');

        if (!$order || !in_array($order, ['name', 'email'])) {
            $order = 'id';
        }

        $comments->setOrder($order);
        
        $this->content = View::factory(
            'Comments',
            [
                'order'    => $order,
                'comments' => $comments->findAll(App::isAdmin()),
            ]
        );
    }

    public function updateAction()
    {
        $this->checkRights();

        $comments = new CommentModel;

        $data = [
            'id'   => $this->request->getRoute('id'),
            'text' => $this->request->getPost('text'),
        ];

        if ($this->request->getPost('delete_image')) {
            $data['image'] = null;
        }

        $comments->update($data);

        $this->redirectToHome();
    }

    public function acceptAction()
    {
        $this->checkRights();

        $comments = new CommentModel;
        $comments->accept($this->request->getRoute('id'));

        $this->redirectToHome();
    }

    public function rejectAction()
    {
        $this->checkRights();

        $comments = new CommentModel;
        $comments->reject($this->request->getRoute('id'));

        $this->redirectToHome();
    }
}
