<?php
/**
 * Project: simple-feedback-form
 * Date: 06.05.16
 * Time: 21:17
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license GPL-3.0
 * @link    http://artlark.ru/
 */

namespace Controllers;

use App;
use Request;
use View;

/**
 * Class Generic
 * @package Controllers
 */
abstract class Generic
{
    /**
     * Default page layout
     * @var string
     */
    protected $layout = 'Layout';

    /**
     * Page title
     * @var string
     */
    protected $title;

    /**
     * Page content
     * @var
     */
    protected $content;

    /**
     * @var Request
     */
    protected $request;

    /**
     * App config
     * @var mixed
     */
    protected $config;

    /**
     * Alerts array
     * @var array
     */
    protected $alerts = [];

    public function __construct()
    {
        $this->request = Request::instance();
        $this->config  = App::config();
    }

    /**
     * Set alert message
     * @param string $message Message text
     * @param string $type    Message type
     */
    public function setAlert($message, $type = 'info')
    {
        $this->alerts[] = [
            'type'    => $type,
            'message' => $message,
        ];
    }

    /**
     * Get content data
     * @return View
     */
    public function getContent()
    {
        if (!empty($this->title)) {
            $this->title = ' - ' . $this->config['app']['title'];
        } else {
            $this->title = $this->config['app']['title'];
        }

        return View::factory(
            $this->layout,
            [
                'title'   => $this->title,
                'alerts'  => $this->alerts,
                'content' => $this->content,
            ]
        );
    }

    /**
     * Simple admin ACL
     */
    protected function checkRights()
    {
        if (!App::isAdmin()) {
            $this->setAlert('You do not have access to this section of site', 'danger');
            $this->redirectToHome();
        }
    }

    /**
     * Simple redirect
     */
    protected function redirectToHome()
    {
        header('Location: /');
        die;
    }
}
