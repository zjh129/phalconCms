<?php
namespace MyApp\Library;

use Phalcon\Mvc\User\Component;

class Uploader extends Component
{
    private $uploader;

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
    public function __construct($config)
    {
        switch ($this->config->environment) {
            case 'dev':
            case 'test':
            case 'production':
                $qiniuUploader = new \MyApp\Library\Upload\UploadQiniu($config);
                $qiniuUploader->setQiniuConfig($this->config->qiniu->phalcontest);
                $this->uploader = $qiniuUploader;
                break;
            default:
                $this->uploader = new \MyApp\Library\Upload\UploadLocal($config);
        }

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
}