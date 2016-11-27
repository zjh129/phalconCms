<?php
header("Content-Type: text/html; charset=utf-8");
error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');
ini_set('display_errors', true);

define('APP_PATH', realpath('..'));

//url不区分大小写
if (isset($_GET['_url'])) {
    $_GET['_url'] = strtolower($_GET['_url']);
}

try {
    // required for autoload,支持composer
    require_once APP_PATH . "/vendor/autoload.php";

    /**
     * Read the configuration
     */
    $config = require_once APP_PATH . "/app/config/config.php";

    /**
     * Read services
     */
    require_once APP_PATH . "/app/config/services.php";


    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);
    /**
     * Include modules
     */
    require_once APP_PATH . '/app/config/modules.php';

    echo $application->handle()->getContent();

} catch (Phalcon\Exception $e) {
    //echo $e->getMessage() . '<br>';
    //echo '<pre>' . $e->getTraceAsString() . '</pre>';
    echo get_class($e), ": ", $e->getMessage(), "<br>";
    echo " File=", $e->getFile(), "<br>";
    echo " Line=", $e->getLine(), "<br>";
    echo str_replace("\n", "<br>", $e->getTraceAsString());
} catch (PDOException $e) {
    echo $e->getMessage(), "<br>";
}

