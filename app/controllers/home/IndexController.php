<?php
namespace MyApp\Home\Controllers;

class IndexController extends BaseController
{
    public function indexAction()
    {
        //print_r(get_loaded_extensions());
        //phpinfo();
        //$this->view->disable();
        //exit();
        $this->view->setVars([
            'title' => '测试标题',
        ]);
        echo "asds";
        $this->view->pick('index/index');
    }
    public function testAction()
    {
        
    }
}