<?php

/**
 * Project: simple-feedback-form
 * Date: 06.05.16
 * Time: 21:25
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license GPL-3.0
 * @link    http://artlark.ru/
 */
class App
{
    /**
     * Get app config
     * @return mixed
     */
    public static function config()
    {
        return include APP_PATH . 'config/app.php';
    }

    /**
     * Check is user logged as admin
     * @return bool
     */
    public static function isAdmin()
    {
        return isset($_SESSION['admin']);
    }

    public function getContent()
    {
        $controller = Request::instance()->getController();
        $action     = Request::instance()->getAction();

        try {

            /** @var \Controllers\Generic $object */
            $object = new $controller;
            $object->$action();
        } catch (Exception $e) {
            $object->setAlert($e->getMessage(), 'danger');
        }

        return $object->getContent();
    }

    public function render()
    {
        echo $this->getContent();
    }
}
