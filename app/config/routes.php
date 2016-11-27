<?php
$router = new Phalcon\Mvc\Router(true);
// 404 错误页面
$router->notFound([
    'controller' => 'errors',
    'action'     => 'show404',
]);
//默认控制器
$router->setDefaultModule("home");
//$router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);
/*$router->setDefaultNamespace('MyApp\Controllers\Home');
$router->setDefaultController('Index');
$router->setDefaultAction('index');*/
//处理结尾额外的斜杆
$router->removeExtraSlashes(true);

$router->add('/', [
    'module'     => 'home',
    'controller' => 'Index',
    'action'     => 'index',
]);
$router->add('/:controller/:action/:params', [
    'module'     => 'home',
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
]);

//后台访问地址
$router->add('/admin/:controller/:action/:params', [
    'module'     => 'admin',
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
]);

//设置后台访问控制器地址
$router->add('/admin', [
    'module'     => 'admin',
    'controller' => 'Index',
    'action'     => 'index',
]);

return $router;
