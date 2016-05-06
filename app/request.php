<?php

/**
 * Project: simple-feedback-form
 * Date: 06.05.16
 * Time: 21:17
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license GPL-3.0
 * @link    http://artlark.ru/
 */
class Request
{
    /**
     * Request instance
     * @var null
     */
    private static $instance = null;

    /**
     * Original request data
     * @var
     */
    private $request;

    private function __construct()
    {
        $this->request = $_REQUEST;
        $this->paths   = explode('/', $this->get('_url'));
    }

    /**
     * Get route path
     * @param string $name
     * @return mixed
     */
    public function getRoute($name)
    {
        switch ($name) {
            case 'controller':
                return isset($this->paths[1]) ? ucfirst($this->paths[1]) : false;
                break;
            case 'action':
                return isset($this->paths[2]) ? strtolower($this->paths[2]) : false;
                break;
            case 'id':
                return isset($this->paths[3]) ? $this->paths[3] : false;
                break;
        }

        return false;
    }

    /**
     * Get controller name
     * @return string
     */
    public function getController()
    {
        $controller = $this->getRoute('controller') ? $this->getRoute('controller') : 'Index';
        return 'Controllers\\' . $controller;
    }

    /**
     * Get action name
     * @return string
     */
    public function getAction()
    {
        $action = $this->getRoute('action') ? $this->getRoute('action') : 'index';
        return $action . 'Action';
    }

    /**
     * Instance
     * @return self
     */
    public static function instance()
    {
        return self::$instance === null ? self::$instance = new static() : self::$instance;
    }

    /**
     * Get request param
     * @param string $param Parameter name
     * @return mixed
     */
    public function get($param)
    {
        return isset($this->request[$param]) ? $this->request[$param] : null;
    }

    /**
     * Get $_POST data
     * @return mixed
     */
    public function getPost($param = null)
    {
        if ($param !== null) {
            return isset($_POST[$param]) ? $_POST[$param] : false;
        }

        return $_POST;
    }

    /**
     * Get $_GET data
     * @return mixed
     */
    public function getQuery($param = null)
    {
        if ($param !== null) {
            return isset($_GET[$param]) ? $_GET[$param] : false;
        }

        return $_GET;
    }
}
