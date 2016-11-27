<?php
namespace MyApp\Admin\Controllers;

use Phalcon\Mvc\Controller;

/**
 * Class BaseController
 * @package MyApp\Admin\Controllers
 * @property \MyApp\Library\Msg $msg;
 * @property \MyApp\Library\Assets $assetsObj
 * @property \MyApp\Library\MyTag $tag
 */
class BaseController extends Controller
{
    //面包屑
    public $breadcrumb = [];

    /**
     * @var $msg
     */
    /**
     * 初始化
     */
    public function initialize()
    {
        $this->url->setBaseUri('/admin/');
        //面包屑
        $this->breadcrumb[] = [
            'title' => '<i class="fa fa-dashboard"></i>首页',
            'url'   => $this->url->get('index/index'),
        ];
        //资源文件管理对象初始化
        $this->assetsObj->addAssets(['bootstrap','Font-Awesome','Ionicons','AdminLTE','jQuery2.2.4','jQuery-UI']);
    }

    /**
     * 在执行控制器/动作方法后触发
     */
    public function afterExecuteRoute()
    {
        //$this->url->setBaseUri('/admin/');
        $this->tag->setTitle("AdminLTE 2");
        $this->tag->setTitleSeparator('-');

        //资源文件注册
        $this->assetsObj->register();

        $this->view->breadcrumb = $this->breadcrumb;
    }
}
