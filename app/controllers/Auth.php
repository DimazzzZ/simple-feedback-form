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
use View;

class Auth extends Generic
{
    public function indexAction()
    {
        if (App::isAdmin()) {
            $this->redirectToHome();
        }

        $post = $_POST;

        if (isset($post['login']) && isset($post['password'])) {
            if ($this->isValidUser($post['login'], $post['password'])) {
                $_SESSION['admin'] = true;
                $this->redirectToHome();
            } else {
                $this->setAlert('Wrong login or password', 'danger');
            }
        }

        $this->content = View::factory('Auth');
    }

    /**
     * Logout user
     */
    public function logoutAction()
    {
        unset($_SESSION['admin']);
        header('Location: /auth');
    }

    /**
     * Check is credentials are right
     * @param string $login    Login
     * @param string $password Password
     * @return bool
     */
    private function isValidUser($login, $password)
    {
        return (($login == $this->config['admin']['login']) && ($password == $this->config['admin']['password']));
    }
}
