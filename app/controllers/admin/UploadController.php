<?php
namespace MyApp\Admin\Controllers;

use Qiniu\Auth;
use Qiniu\Config;
use Qiniu\Storage\UploadManager;
use Phalcon\Security\Random;

/**
 * Created by PhpStorm.
 * User: qianxun
 * Date: 16-10-20
 * Time: 上午10:40
 */
class UploadController extends BaseController
{
    //上传类别
    private $uploadType = 'qiniu';
    /**
     * 上传文件
     */
    public function uploadfileAction()
    {
        sleep(5);
        exit();
        $qiniuConfig = $this->config->qiniu->phalcontest;

        $auth = new Auth($qiniuConfig->accessKey, $qiniuConfig->secretKey);
        // 生成上传Token
        $token = $auth->uploadToken($qiniuConfig->bucket);

        $filePath = APP_PATH . '/public/AdminLTE/dist/img/avatar.png';
        $fileInfo = pathinfo($filePath);
        // 初始化 UploadManager 对象并进行文件的上传
        $uploadZone = new \Qiniu\Zone($qiniuConfig->upHost, $qiniuConfig->upHostBackup);
        $uploadConfig = new \Qiniu\Config($uploadZone);
        $uploadMgr = new UploadManager($uploadConfig);
        // 上传到七牛后保存的文件名
        $random = new Random();
        $key = date("Y/m/d/") . $random->uuid() . '.' . $fileInfo['extension'];
        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            var_dump($err);
        } else {
            var_dump($ret);
        }
        exit();
    }
    public function webuploaderAction()
    {
        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $config = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
        $action = $this->request->getQuery('action');
        switch ($action){
            case 'config':
                $this->msg->outputJson($config);
                break;
            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = include("action_upload.php");
                break;
            /* 列出图片 */
            case 'listimage':
                $result = include("action_list.php");
                break;
            /* 列出文件 */
            case 'listfile':
                $result = include("action_list.php");
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = include("action_crawler.php");
                break;

            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }

    }

    /**
     * 百度编辑器上传
     */
    public function uedituploaderAction()
    {

    }

    /**
     * 七牛文件上传
     */
    private function qiniuUploadfile()
    {
        // Check if the user has uploaded files
        if ($this->request->hasFiles()) {
            // 5 minutes execution time
            @set_time_limit(5 * 60);

            $qiniuConfig = $this->config->qiniu->phalcontest;

            $auth = new Auth($qiniuConfig->accessKey, $qiniuConfig->secretKey);
            // 生成上传Token
            $token = $auth->uploadToken($qiniuConfig->bucket);

            // 初始化 UploadManager 对象并进行文件的上传
            $uploadZone = new \Qiniu\Zone($qiniuConfig->upHost, $qiniuConfig->upHostBackup);
            $uploadConfig = new \Qiniu\Config($uploadZone);
            $uploadMgr = new UploadManager($uploadConfig);

            $files = $this->request->getUploadedFiles();

            // Print the real file names and sizes
            foreach ($files as $file) {
                //文件信息
                $fileInfo = pathinfo($file->getName());
                // 上传到七牛后保存的文件名
                $random = new Random();
                $key = date("Y/m/d/") . $random->uuid() . '.' . $fileInfo['extension'];
                // 调用 UploadManager 的 putFile 方法进行文件的上传
                list($ret, $err) = $uploadMgr->putFile($token, $key, $file->getTempName());
                if ($err !== null) {
                    $callback = $this->msg->getJsonCallback('error','文件上传错误:'.$err->message());
                } else {
                    $callback = $this->msg->getJsonCallback('success','文件上传成功', [
                        'url' => $qiniuConfig->domain . $ret['key'],
                        'title' => $file->getName(),
                        'mimeType' => $file->getType(),
                        'type' => $fileInfo['extension'],
                        'size' => $file->getSize(),
                    ]);
                }
                $this->msg->outputJson($callback);
            }
        }else{
            header("HTTP/1.0 500 Internal Server Error");
        }
    }

    /**
     *本地文件上传
     */
    private function localUploaderfile()
    {

    }

    /**
     * 本地列出文件
     * @param $type image:图片，file：文件
     */
    private function listFile($type = 'image')
    {

    }

    /**
     * 抓取远程文件
     */
    private function catchimage()
    {

    }
}