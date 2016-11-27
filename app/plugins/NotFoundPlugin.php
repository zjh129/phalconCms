<?php
namespace MyApp\Plugins;

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

/**
 * NotFoundPlugin
 *
 * Handles not-found controller/actions
 */
class NotFoundPlugin extends Plugin
{

	/**
	 * This action is executed before execute any action in the application
	 *
	 * @param Event $event
	 * @param MvcDispatcher $dispatcher
	 * @param Exception $exception
	 * @return boolean
	 */
	public function beforeException(Event $event, MvcDispatcher $dispatcher, Exception $exception)
	{
		error_log($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());

		if ($exception instanceof DispatcherException) {
			switch ($exception->getCode()) {
				case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
				case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
				    if ($this->request->isAjax()){
                        $this->msg->show('show404');
                    }else{
                        $dispatcher->forward([
                            'controller' => 'errors',
                            'action' => 'show404'
                        ]);
                    }
					//echo $dispatcher->getReturnedValue();exit();
					return false;
			}
		}

		if ($this->request->isAjax()){
            $this->msg->show('show500');
        }else{
            $dispatcher->forward([
                'controller' => 'errors',
                'action'     => 'show500'
            ]);
        }
		return false;
	}
}
