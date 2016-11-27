<?php
use Phalcon\DI\FactoryDefault,
    Phalcon\Mvc\View,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\Url as UrlResolver,
    Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
    Phalcon\Mvc\View\Engine\Volt as VoltEngine,
    Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter,
    Phalcon\Session\Adapter\Files as SessionAdapter,
    Phalcon\Logger\Adapter\File as LoggerFile,
    Phalcon\Crypt,
    Phalcon\Security;


/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

//将配置设置为全局可调用
$di->setShared('config', function () use ($config) {
    return $config;
});

$di->set('router', function () {
    return require APP_PATH . '/app/config/routes.php';
}, true);

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter([
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'options'  => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
            PDO::ATTR_CASE               => PDO::CASE_LOWER,
        ],
    ]);
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () use ($config) {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function () {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});

//通过类名和参数，注册logger服务
$di->set('logger', function () use ($config) {
    return new LoggerFile($config->logger->application);
});

//配置加密服务
$di->set('crypt', function () {
    $crypt = new Crypt();
    //设置全局加密密钥
    $crypt->setKey('qianxun!@#$%^&*()_+zhaojianhui');
    return $crypt;
}, false);

//设置security组件
$di->set('security', function () {
    $security = new Security();
    // Set the password hashing factor to 12 rounds
    $security->setWorkFactor(12);

    return $security;
}, true);

//设置消息组件
$di->set('msg', function () {
    return new MyApp\Library\Msg();
}, true);

//设置资源文件管理对象
$di->set('assetsObj', function () {
    return new MyApp\Library\Assets();
}, true);

//设置tag服务
$di->set('tag', function (){
    return new MyApp\Library\MyTag();
});