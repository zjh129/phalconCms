<?php
namespace MyApp\Admin\Controllers;

use Phalcon\Mvc\View;

class ErrorsController extends BaseController
{
    /**
     * 页面信息提示
     * @param string $type 提示类型
     * @param string $msgTitle 提示标题
     * @param mixed $redirectUrl 跳转地址，内容是复合类型，使用url的get方法生成链接
     * @param string $msgCon 提示附加内容
     * @param number $waitSecond 等待描述
     */
    public function showmsgAction($type = 'success', $msgTitle = '操作成功', $redirectUrl = '', $msgCon = '', $waitSeconds = 3)
    {
        if ($redirectUrl) {
            $redirectUrl = $this->url->get($redirectUrl);
        } else {
            $redirectUrl = $_SERVER['HTTP_REFERER'];
        }
        switch ($type) {
            case 'error':
                //提示div样式名
                $this->view->boxClass = 'alert-danger';
                //提示图标样式
                $this->view->iconClass = 'icon-warning-sign';
                //$this->flash->error("too bad! the form had errors");
                break;
            case 'notice':
                $this->view->boxClass = 'alert-info';
                $this->view->iconClass = 'icon-info-sign';
                //$this->flash->notice("this a very important information");
                break;
            case 'warning':
                $this->view->boxClass = 'alert-warning';
                $this->view->iconClass = 'icon-exclamation-sign';
                //$this->flash->warning("best check yo self, you're not looking too good.");
                break;
            default:
                $this->view->boxClass = 'alert-success';
                $this->view->iconClass = 'icon-check-circle';
            //$this->flash->success("yes!, everything went very smoothly");
        }

        $this->view->msgTitle = $msgTitle;
        $this->view->msgCon = $msgCon;
        $this->view->redirectUrl = $redirectUrl;
        $this->view->waitSeconds = $waitSeconds;

        $this->view->pick("public/showmsg");
        //关闭渲染级别
        $this->view->disableLevel([
            View::LEVEL_LAYOUT      => true,
            View::LEVEL_MAIN_LAYOUT => true,
        ]);
    }

    /**
     * 未经授权,认证失败
     * @return [type] [description]
     */
    public function show401Action()
    {
        //$this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $this->response->setStatusCode(401, "No Authorized");
        //关闭渲染级别
        /*$this->view->disableLevel([
            View::LEVEL_LAYOUT      => true,
            View::LEVEL_MAIN_LAYOUT => true,
        ]);*/
    }

    /**
     * 404错误页面
     * @return [type] [description]
     */
    public function show404Action()
    {
        //$this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $this->response->setStatusCode(404, "Not Found");
        //关闭渲染级别
        /*$this->view->disableLevel([
            View::LEVEL_LAYOUT      => true,
            View::LEVEL_MAIN_LAYOUT => true,
        ]);*/
    }

    /**
     * 500错误页面
     * @return [type] [description]
     */
    public function show500Action()
    {
        //$this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $this->response->setStatusCode(500, "Service Error");
        //关闭渲染级别
        /*$this->view->disableLevel([
            View::LEVEL_LAYOUT      => true,
            View::LEVEL_MAIN_LAYOUT => true,
        ]);*/
    }

    /**
     * 503错误页面,服务器拒绝
     */
    public function show503Action()
    {
        //$this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        $this->response->setStatusCode(503, "Service Refuse");
        //关闭渲染级别
        /*$this->view->disableLevel([
            View::LEVEL_LAYOUT      => true,
            View::LEVEL_MAIN_LAYOUT => true,
        ]);*/
    }
}