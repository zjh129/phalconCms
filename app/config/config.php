<?php
return new \Phalcon\Config([
    'environment' => 'dev1',//环境常亮（dev：开发;test:测试;production：生产）
    'database'    => [
        'adapter'  => 'Mysql',
        'host'     => '172.17.0.2',
        'username' => 'root',
        'password' => '123456',
        'dbname'   => 'phalconCms',
    ],
    'application' => [
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'modulesDir'     => APP_PATH . '/app/modules/',
        'formsDir'       => APP_PATH . '/app/forms/',
        'viewsDir'       => APP_PATH . '/app/views/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
        'libraryDir'     => APP_PATH . '/app/library/',
        'cacheDir'       => APP_PATH . '/app/cache/',
        'baseUri'        => '/',
    ],
    'module'      => [
        'default' => 'home',
        'list'    => ['home', 'admin'],
    ],
    'session'     => [
        'adminUserKey' => 'adminUserInfo', //用户信息session的Key
    ],
    'logger'      => [
        'application' => APP_PATH . '/app/logs/application.log',
        'sql'         => APP_PATH . '/app/runtime/sql.log',
    ],
    'qiniu'       => [
        'phalconcms'  => [
            'domain'       => 'http://ofas5213a.bkt.clouddn.com/',
            'bucket'       => 'phalconcms',
            'accessKey'    => 'kk3W4E5lUtGvclg_4QNabQ54RnnFPsZCn1xDRysA',
            'secretKey'    => 'BpPa4z51B-k8uLf4-ebKuVUmQE2KVE_RFO8JfdLT',
            'upHost'       => 'http://up-z2.qiniu.com',
            'upHostBackup' => 'http://upload-z2.qiniu.com',
        ],
        'phalcontest' => [
            'domain'       => 'http://ofcalqdk5.bkt.clouddn.com/',
            'bucket'       => 'phalcontest',
            'accessKey'    => 'hok8IyN6XqKnGyiw4GmDmB0IFPN-TIal7hFLdXzv',
            'secretKey'    => 'em2b9_hXPt3NvxOJGS83Xq8gNmJErbtLItJSSwhN',
            'upHost'       => 'http://up-z0.qiniu.com',
            'upHostBackup' => 'http://upload-z0.qiniu.com',
        ],
    ],
]);
