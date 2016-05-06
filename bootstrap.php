<?php
/**
 * Project: simple-feedback-form
 * Date: 06.05.16
 * Time: 21:02
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license GPL-3.0
 * @link    http://artlark.ru/
 */

session_start();

require_once 'app/config/constants.php';
require_once 'app/config/autoload.php';

(new App)->render();
