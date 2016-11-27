<?php
namespace MyApp\Modules;

use MyApp\Plugins\ExceptionsPlugin;
use MyApp\Plugins\NotFoundPlugin;
use MyApp\Plugins\SecurityPlugin;
use Phalcon\DiInterface;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Flash\Direct as FlashDirect;

class AdminModule implements ModuleDefinitionInterface
{
    /**
     * Registers the module auto-loader
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $config = $di['config'];
        $loader = new Loader();

        /**
         * We're a registering a set of directories taken from the configuration file
         */
        $loader->registerDirs([
            $config->application->controllersDir,
            $config->application->pluginsDir,
            $config->application->libraryDir,
            $config->application->modelsDir,
            $config->application->formsDir,
        ])->register();

        $loader->registerNamespaces(
            [
                'MyApp\Admin\Controllers' => APP_PATH . '/app/controllers/admin',
                'MyApp\Admin\Forms'       => APP_PATH . '/app/forms/admin',
                'MyApp\Models'            => APP_PATH . '/app/models',
                'MyApp\Library'           => APP_PATH . '/app/library',
                'MyApp\Plugins'           => APP_PATH . '/app/plugins',
            ]
        );

        $loader->register();
    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        $config = $di['config'];
        // Registering a dispatcher
        $di->set('dispatcher', function () {
            $eventsManager = new EventsManager;
            /**
             * Check if the user is allowed to access certain action using the SecurityPlugin
             */
            //权限验证,在进入循环调度后触发
            $eventsManager->attach('dispatch:beforeDispatch', new SecurityPlugin('admin'));

            /**
             * Handle exceptions and not-found exceptions using NotFoundPlugin
             */
            //错误页面,在调度器抛出任意异常前触发
            //$eventsManager->attach('dispatch:beforeNotFoundAction', new NotFoundPlugin);
            //$eventsManager->attach('dispatch:beforeException', new ExceptionsPlugin);

            $dispatcher = new Dispatcher;
            $dispatcher->setDefaultNamespace('MyApp\Admin\Controllers\\');
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        });

        // Registering the view component
        $di->set('view', function () use ($config) {
            $view = new View();
            $view->setViewsDir($config->application->viewsDir . 'admin/');

            $view->registerEngines([
                '.volt'  => function ($view, $di) use ($config) {

                    $volt = new VoltEngine($view, $di);

                    $volt->setOptions([
                        'compiledPath'      => $config->application->cacheDir,
                        'compiledSeparator' => '_',
                    ]);

                    return $volt;
                },
                '.phtml' => 'Phalcon\Mvc\View\Engine\Php', // Generate Template files uses PHP itself as the template engine
            ]);
            return $view;
        });

        $di->set('flash', function () {
            $flash = new FlashDirect(
                array(
                    'error'   => 'alert alert-danger',
                    'success' => 'alert alert-success',
                    'notice'  => 'alert alert-info',
                    'warning' => 'alert alert-warning'
                )
            );

            return $flash;
        });

    }
}
