<?php
namespace MyApp\Home\Controllers;

use Phalcon\Mvc\Controller;

/**
 * Class BaseController
 * @package MyApp\Admin\Controllers
 * @property \MyApp\Library\Msg $msg
 * @property \MyApp\Library\MyTag $tag
 */

class BaseController extends Controller
{
    public $modelName = 'home';
    /**
     * 初始化
     */
    public function initialize()
    {
        $this->url->setBaseUri('/');
    }
    /**
     * 在执行控制器/动作方法后触发
     */
    public function afterExecuteRoute()
    {
        //设置视图路径
        //$this->view->setViewsDir($this->config->application->viewsDir . 'home/');
    }
}