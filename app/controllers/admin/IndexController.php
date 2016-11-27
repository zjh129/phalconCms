<?php
namespace MyApp\Admin\Controllers;

use MyApp\Models\Users;

class IndexController extends BaseController
{
    /**
     * 仪表盘
     */
    public function indexAction()
    {
        $this->tag->appendTitle("仪表盘");
        $this->breadcrumb[] = [
            'title' => '仪表盘',
            'url'   => '',
        ];
        $systemName = php_uname('s');
        $systemInfo = [
            [
                'name'  => '操作系统名称',
                'value' => $systemName,
                'icon'  => strpos(strtolower($systemName), 'linux') !== false ? 'ion ion-social-tux' : 'ion ion-social-windows-outline',
            ],
            [
                'name'  => '系统版本信息',
                'value' => php_uname('v'),
                'icon'  => 'ion ion-gear-a',
            ],
            [
                'name'  => '系统版本名称',
                'value' => php_uname('r'),
                'icon'  => 'ion ion-ios-speedometer',
            ],
            [
                'name'  => 'PHP运行方式',
                'value' => php_sapi_name(),
                'icon'  => 'ion ion-ios-bolt',
            ],
            [
                'name'  => '前进程用户名',
                'value' => Get_Current_User(),
                'icon'  => 'ion ion-android-person',
            ],
            [
                'name'  => 'PHP版本',
                'value' => PHP_VERSION,
                'icon' => 'ion ion-ios-cog'
            ],
            [
                'name'  => 'Zend版本',
                'value' => Zend_Version(),
                'icon' => 'ion ion-ios-pricetags'
            ],
            [
                'name'  => 'PHP安装路径',
                'value' => DEFAULT_INCLUDE_PATH,
                'icon' => 'ion ion-ios-browsers'
            ],
            [
                'name'  => 'Http请求中Host值',
                'value' => $_SERVER["HTTP_HOST"],
                'icon' => 'ion ion-android-globe'
            ],
            [
                'name'  => '服务器IP',
                'value' => GetHostByName($_SERVER['SERVER_NAME']),
                'icon' => 'ion ion-android-locate'
            ],
            [
                'name'  => '客户端IP',
                'value' => $_SERVER['REMOTE_ADDR'],
                'icon' => 'ion ion-android-wifi'
            ],
            [
                'name'  => '服务器解译引擎',
                'value' => $_SERVER['SERVER_SOFTWARE'],
                'icon' => 'ion ion-ios-color-filter'
            ],
            [
                'name'  => '服务器语言',
                'value' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
                'icon' => 'ion ion-aperture'
            ],
            [
                'name'  => '服务器Web端口',
                'value' => $_SERVER['SERVER_PORT'],
                'icon' => 'ion ion-shuffle'
            ],
            [
                'name'  => '最大上传限制',
                'value' => ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled",
                'icon' => 'ion ion-upload'
            ],
            [
                'name'  => '最大执行时间',
                'value' => ini_get("max_execution_time") . "秒",
                'icon' => 'ion ion-ios-alarm'
            ],
        ];
        $this->view->systemInfo = $systemInfo;
    }
}