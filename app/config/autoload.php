<?php
/**
 * Project: simple-feedback-form
 * Date: 06.05.16
 * Time: 21:19
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license GPL-3.0
 * @link    http://artlark.ru/
 */

function __autoload($classname)
{
    include_once(APP_PATH. lcfirst(str_replace('\\', '/', $classname)) . '.php');
}
