<?php
namespace MyApp\Home\Controllers;

use Phalcon\Mvc\View;

class ErrorsController extends BaseController
{
    /**
     * 未经授权
     * @return [type] [description]
     */
    public function show401Action()
    {

    }

    /**
     * 404错误页面
     * @return
     */
    public function show404Action()
    {
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $this->response->setStatusCode(404, "Not Found");
    }

    /**
     * 500错误页面
     * @return [type] [description]
     */
    public function show500Action()
    {

    }
}