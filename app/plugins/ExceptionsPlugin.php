<?php
namespace MyApp\Plugins;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;
use Phalcon\Mvc\User\Plugin;

class ExceptionsPlugin extends Plugin
{
    public function beforeException(Event $event, Dispatcher $dispatcher, $exception)
    {
        // 处理404异常
        if ($exception instanceof DispatchException) {
            if ($this->request->isAjax()){
                $this->msg->show('show404');
            }else{
                $dispatcher->forward(array(
                    'controller' => 'errors',
                    'action'     => 'show404'
                ));
            }
            return false;
        }

        // 处理其他异常
        if ($this->request->isAjax()){
            $this->msg->show('show503');
        }else{
            $dispatcher->forward(array(
                'controller' => 'errors',
                'action'     => 'show503'
            ));
        }

        return false;
    }
}