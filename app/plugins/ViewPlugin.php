<?php
namespace MyApp\Plugins;

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

/**
 * NotFoundPlugin
 *
 * Handles not-found controller/actions
 */
class ViewPlugin extends Plugin
{
    /**
     * 视图不存在时触发
     */
    public function notFoundView(Event $event, MvcDispatcher $dispatcher)
    {
        echo "视图不存在";exit();
        return false;
    }
}