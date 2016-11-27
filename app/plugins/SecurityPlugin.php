<?php
namespace MyApp\Plugins;

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Resource;
use Phalcon\Acl\Role;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;

/**
 * SecurityPlugin
 *
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityPlugin extends Plugin
{
    private $moduleName = '';

    public function __construct($moduleName)
    {
        $this->moduleName = $moduleName;
    }

    /**
     * Returns an existing or new access control list
     *
     * @returns AclList
     */
    public function getAcl()
    {
        //if (!isset($this->persistent->acl)) {

        $acl = new AclList();

        $acl->setDefaultAction(Acl::DENY);

        // Register roles
        $roles = [
            'users'  => new Role(
                'Users',
                'Member privileges, granted after sign in.'
            ),
            'guests' => new Role(
                'Guests',
                'Anyone browsing the site who is not signed in is considered to be a "Guest".'
            ),
        ];

        foreach ($roles as $role) {
            $acl->addRole($role);
        }

        //Private area resources
        $privateResources = [
            'admin/companies'    => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete'],
            'admin/products'     => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete'],
            'admin/producttypes' => ['index', 'search', 'new', 'edit', 'save', 'create', 'delete'],
            'admin/invoices'     => ['index', 'profile'],
            'admin/index'        => ['index'],
            'admin/user'         => ['profile', 'index', 'add', 'checkaccount', 'edit', 'del'],
            'admin/upload'       => ['uploadfile','webuploader'],
        ];
        foreach ($privateResources as $resource => $actions) {
            $acl->addResource(new Resource($resource), $actions);
        }

        //Public area resources
        $publicResources = [
            'home/index'    => ['index'],
            'home/about'    => ['index'],
            'home/register' => ['index'],
            'home/contact'  => ['index', 'send'],
            'home/errors'   => ['show401', 'show404', 'show500'],
            'home/public'   => ['login'],
            'admin/errors'  => ['show401', 'show404', 'show500'],
            'admin/public'  => ['login', 'logout', 'captcha'],
        ];
        foreach ($publicResources as $resource => $actions) {
            $acl->addResource(new Resource($resource), $actions);
        }

        //Grant access to public areas to both users and guests
        foreach ($roles as $role) {
            foreach ($publicResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow($role->getName(), $resource, $action);
                }
            }
        }

        //Grant access to private area to role Users
        foreach ($privateResources as $resource => $actions) {
            foreach ($actions as $action) {
                $acl->allow('Users', $resource, $action);
            }
        }

        //The acl is stored in session, APC would be useful here too
        $this->persistent->acl = $acl;
        //}

        return $this->persistent->acl;
    }

    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $userKey = $this->config->session->adminUserKey;
        $auth = $this->session->get($userKey);
        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        $controller = strtolower($this->moduleName . '/' . $dispatcher->getControllerName());
        $action = strtolower($dispatcher->getActionName());

        $acl = $this->getAcl();

        if (!$acl->isResource($controller)) {
            if ($this->request->isAjax()) {
                $this->msg->show('show404');
            } else {
                $dispatcher->forward([
                    'controller' => 'errors',
                    'action'     => 'show404',
                ]);
            }

            return false;
        }

        $allowed = $acl->isAllowed($role, $controller, $action);
        if ($allowed != Acl::ALLOW) {
            //如果收后台，宾客不允许访问，直接跳转至登录页
            if ($this->moduleName == 'admin' && $role == 'Guests') {
                if ($this->request->isAjax()) {
                    $this->msg->show('error', '请重新登录', $this->url->get('public/login'));
                } else {
                    $dispatcher->forward([
                        'controller' => 'public',
                        'action'     => 'login',
                    ]);
                }
                return false;
            }
            if ($this->request->isAjax()) {
                $this->msg->show('show401');
            } else {
                $dispatcher->forward([
                    'controller' => 'errors',
                    'action'     => 'show401',
                ]);
            }
            //$this->session->destroy();
            return false;
        }
    }
}
