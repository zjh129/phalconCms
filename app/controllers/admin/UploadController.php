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
     * 百度编辑器上传
     */
    public function uedituploaderAction()
    {
        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        ini_set('upload_max_filesize', '100m');
        //ini_set('memory_limit', '100m');

        $jsonConfig = (new \MyApp\Library\Uploader([]))->getJsonConfig();

        $action = $this->request->getQuery('action');
        switch ($action) {
            case 'config':
                $this->msg->outputJson($jsonConfig);
                break;
            /* 上传图片 */
            case 'uploadimage':
                $uploader = new \MyApp\Library\Uploader([
                    "pathFormat" => $jsonConfig['imagePathFormat'],
                    "maxSize"    => $jsonConfig['imageMaxSize'],
                    "allowFiles" => $jsonConfig['imageAllowFiles'],
                ]);
                $result = $uploader->upFile($jsonConfig['imageFieldName']);
                $uploader->saveDataToTable('image');
                break;
            /* 上传涂鸦 */
            case 'uploadscrawl':
                $uploader = new \MyApp\Library\Uploader([
                    "pathFormat" => $jsonConfig['scrawlPathFormat'],
                    "maxSize"    => $jsonConfig['scrawlMaxSize'],
                    "allowFiles" => $jsonConfig['imageAllowFiles'],
                    "oriName"    => "scrawl.png",
                ]);
                $result = $uploader->upBase64($jsonConfig['scrawlFieldName']);
                $uploader->saveDataToTable('image');
                break;
            /* 上传视频 */
            case 'uploadvideo':
                $uploader = new \MyApp\Library\Uploader([
                    "pathFormat" => $jsonConfig['videoPathFormat'],
                    "maxSize"    => $jsonConfig['videoMaxSize'],
                    "allowFiles" => $jsonConfig['videoAllowFiles'],
                ]);
                $result = $uploader->upFile($jsonConfig['videoFieldName']);
                $uploader->saveDataToTable('video');
                break;
            /* 上传文件 */
            case 'uploadfile':
                $uploader = new \MyApp\Library\Uploader([
                    "pathFormat" => $jsonConfig['filePathFormat'],
                    "maxSize"    => $jsonConfig['fileMaxSize'],
                    "allowFiles" => $jsonConfig['fileAllowFiles']
                ]);
                $result = $uploader->upFile($jsonConfig['fileFieldName']);
                $uploader->saveDataToTable('file');
                break;
            /* 列出图片 */
            case 'listimage':
                $size = (int) $this->request->get('size', 'int', $jsonConfig['imageManagerListSize']);
                $start = (int) $this->request->get('start', 'int', 0);
                $result = (new \MyApp\Library\Uploader())->getFileList('image', $start, $size);
                break;
            /* 列出文件 */
            case 'listfile':
                $size = (int) $this->request->get('size', 'int', $jsonConfig['imageManagerListSize']);
                $start = (int) $this->request->get('start', 'int', 0);
                $result = (new \MyApp\Library\Uploader())->getFileList('file', $start, $size);
                break;
            /* 抓取远程文件 */
            case 'catchimage':
                $uploader = new \MyApp\Library\Uploader([
                    "pathFormat" => $jsonConfig['catcherPathFormat'],
                    "maxSize"    => $jsonConfig['catcherMaxSize'],
                    "allowFiles" => $jsonConfig['catcherAllowFiles'],
                    "oriName"    => "remote.png",
                ]);
                $result = $uploader->saveRemote($jsonConfig['catcherFieldName']);
                $uploader->saveDataToTable('image');
                break;
            default:
                $result = [
                    'state' => '请求地址出错'
                ];
                break;
        }
        $this->msg->outputJson($result);
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
                    $callback = $this->msg->getJsonCallback('error', '文件上传错误:' . $err->message());
                } else {
                    $callback = $this->msg->getJsonCallback('success', '文件上传成功', [
                        'url'      => $qiniuConfig->domain . $ret['key'],
                        'title'    => $file->getName(),
                        'mimeType' => $file->getType(),
                        'type'     => $fileInfo['extension'],
                        'size'     => $file->getSize(),
                    ]);
                }
                $this->msg->outputJson($callback);
            }
        } else {
            header("HTTP/1.0 500 Internal Server Error");
        }
    }
}