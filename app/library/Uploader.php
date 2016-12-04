<?php
namespace MyApp\Library;

use Phalcon\Mvc\User\Component;

class Uploader extends Component
{
    private $jsonConfig;
    private $uploadType;//文件上传方式
    private $uploader;
    private $userId;//用户ID

    /**
     * Uploader constructor.
     * [
     * 上传保存路径
     * 'pathFormat' => '/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}',
     *  上传大小限制，单位B
     * 'maxSize' => 2048000,
     * 上传图片格式限制
     * 'allowFiles' => [".png", ".jpg", ".jpeg", ".gif", ".bmp"],
     * 原始图片名称，可省略
     * 'oriName' => '',
     * ]
     * @param $config
     */
    public function __construct($config = [])
    {
        $this->jsonConfig = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(APP_PATH . "/public/plugins/ueditor/php/config.json")), true);

        switch ($this->config->environment) {
            case 'dev':
            case 'test':
            case 'production':
                $this->uploadType = 'qiniu';
                break;
            default:
                $this->uploadType = 'local';
        }
        //设置上传类
        switch ($this->uploadType) {
            case 'qiniu':
                $qiniuUploader = new \MyApp\Library\Upload\UploadQiniu($config);
                $qiniuUploader->setQiniuConfig($this->config->qiniu->phalcontest);
                $this->uploader = $qiniuUploader;

                //设置抓取远程图片配置本地域名
                $this->jsonConfig['catcherLocalDomain'][] = $this->config->qiniu->phalcontest->domain;
                break;
            case 'local':

            default:
                $this->uploader = new \MyApp\Library\Upload\UploadLocal($config);
        }
        //用户session KEY
        $userKey = $this->config->session->adminUserKey;
        $userInfo = $this->session->get($userKey);
        $this->userI = (int) $userInfo['user_id'];
    }

    /**
     * 获取百度编辑器json配置
     * @return mixed
     */
    public function getJsonConfig()
    {
        return $this->jsonConfig;
    }

    /**
     * 上传文件
     * @param $fileField
     * @return bool
     */
    public function upFile($fileField)
    {
        $this->uploader->upFile($fileField);

        return $this->uploader->getFileInfo();
    }

    /**
     * 上传编码64图片
     * @param $fileField
     * @return array
     */
    public function upBase64($fileField)
    {
        $this->uploader->upBase64($fileField);

        return $this->uploader->getFileInfo();
    }

    /**
     * 上传远程图片
     * @param $fileField
     * @return array
     */
    public function saveRemote($fileField)
    {
        $this->uploader->saveRemote($fileField);

        return $this->uploader->getFileInfo();
    }

    /**
     * 保存文件数据到数据表
     * @param array $fileInfo
     */
    public function saveDataToTable($type)
    {
        //文件信息
        $fileInfo = $this->uploader->getFileInfo();
        if ($fileInfo['state'] == 'SUCCESS') {
            $fileModel = new \MyApp\Models\Files();
            $fileModel->save([
                'user_id' => $this->userI,
                'type' => $type,
                'uploadType' => $this->uploadType,
                'url' => $fileInfo['url'],
                'fileName' => $fileInfo['title'],
                'oriName' => $fileInfo['original'],
                'fileExt' => $fileInfo['type'],
                'size' => $fileInfo['size'],
            ]);
        }

    }

    public function getFileList($type, $start = 0, $size = 10)
    {
        $fileModel = new \MyApp\Models\Files();
        $files = $fileModel::find([
            "user_id=:user_id: AND type=:type:",
            "bind" => [
                "user_id" => $this->userId,
                'type' => $type
            ],
            'order' => "create_at DESC",
            'offset' => $start,
            'limit' => $size,
        ]);

    }
}