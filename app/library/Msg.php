<?php
namespace MyApp\Library;

use Phalcon\Mvc\User\Component;

/**
 *
 * 消息输出组件，用户返回对应用户数据
 * @package MyApp\Library
 */
class Msg extends Component
{
    /**
     * 页面消息返回
     * @param string $type
     * @param string $msg
     * @param string $redirectUrl
     * @param array $content
     */
    public function show($type = 'success', $msg = '', $content = [], $redirectUrl = '')
    {
        if ($this->request->isAjax()) {
            $callback = $this->getJsonCallback($type, $msg, $content, $redirectUrl);
            $this->outputJson($callback);
        } else {
            switch ($type) {
                case 'error':
                    $action = 'showmsg';
                    $title = '操作失败';
                    break;
                case 'notice':
                    $action = 'showmsg';
                    $title = '信息提示';
                    break;
                case 'warning':
                    $action = 'showmsg';
                    $title = '警告信息';
                    break;
                case 'show401':
                    $action = 'show401';
                    $title = '未授权';
                    break;
                case 'show404':
                    $action = 'show404';
                    $title = '页面不存在';
                    break;
                case 'show500':
                    $action = 'show500';
                    $title = '服务器错误';
                    break;
                case 'show503':
                    $action = 'show503';
                    $title = '服务器拒绝';
                    break;
                default:
                    $action = 'showmsg';
                    $title = '操作成功';
            }
            $this->dispatcher->forward([
                'controller' => 'errors',
                'action'     => $action,
                'params'     => [
                    'type'        => $type,
                    'msgTitle'    => $title,
                    'msgCon'      => $msg,
                    'redirectUrl' => $redirectUrl,
                ],
            ]);
        }
    }
    /**
     * 返回json对应的数组
     * json code返回值参考地址：http://www.cnblogs.com/shanyou/archive/2012/05/06/2486134.html
     * @param string $type
     * @param string $msg
     * @param array $content
     * @param string $redirectUrl
     * @return array
     */
    public function getJsonCallback($type = 'success', $msg = '', $content = [], $redirectUrl = '')
    {
        switch ($type) {
            case 'error':
                $code = 403;
                $msg || $msg = '操作失败';
                $msg = '<span class="glyphicon glyphicon-remove" style = "font-size:20px;color: #dd4b39;"> ' . $msg . '</span>';
                break;
            case 'notice':
                $code = 200;
                $msg || $msg = '信息提示';
                $msg = '<span class="glyphicon glyphicon-info-sign" style = "font-size:20px;color: #00c0ef;"> ' . $msg . '</span>';
                break;
            case 'warning':
                $code = 403;
                $msg || $msg = '警告信息';
                $msg = '<span class="glyphicon glyphicon-warning-sign" style = "font-size:20px;color: #f39c12;"> ' . $msg . '</span>';
                break;
            case 'show401':
                //header ( "Status: 401 No Authorized" );
                $code = 401;
                $msg || $msg = '未授权';
                $msg = '<span class="glyphicon glyphicon-minus-sign" style = "font-size:20px;color: #dd4b39;"> ' . $msg . '</span>';
                break;
            case 'show404':
                //header ( "Status: 404 Not Found" );
                $code = 404;
                $msg || $msg = '页面不存在';
                $msg = '<span class="glyphicon glyphicon-minus-sign" style = "font-size:20px;color: #dd4b39;"> ' . $msg . '</span>';
                break;
            case 'show500':
                //header ( "Status: 500 Service Error" );
                $code = 500;
                $msg || $msg = '服务器错误';
                $msg = '<span class="glyphicon glyphicon-exclamation-sign" style = "font-size:20px;color: #dd4b39;"> ' . $msg . '</span>';
                break;
            case 'show503':
                //header ( "Status: 500 Service Refuse" );
                $code = 503;
                $msg || $msg = '服务器拒绝';
                $msg = '<span class="glyphicon glyphicon-exclamation-sign" style = "font-size:20px;color: #dd4b39;"> ' . $msg . '</span>';
            default:
                $code = 200;
                $msg || $msg = '操作成功';
                $msg = '<span class="glyphicon glyphicon-ok" style = "font-size:20px;color: #00a65a;"> ' . $msg . '</span>';
        }

        $callback = [
            'code'        => $code,
            'message'     => $msg,
            'redirectUrl' => $redirectUrl,
            'content'     => $content,
        ];
        return $callback;
    }
    /**
     * 输出json格式
     * @param array $content
     */
    public function outputJson($data = [], $jsonp = '')
    {
        header('Content-type: application/json; charset=utf-8');

        $this->response->setJsonContent($data);
        //自动识别是否存在callback参数
        if (!$jsonp) {
            $jsonp = $this->request->get('callback', 'string', '');
        }
        if ($jsonp) {
            echo htmlspecialchars($jsonp . '(' . $this->response->getContent() . ')');
        } else {
            echo $this->response->getContent();
        }
        $this->view->disable();
        exit();
    }
}