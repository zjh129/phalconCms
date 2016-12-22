<?php
namespace MyApp\Library\Upload;


interface UploadInterface
{
    public function setJsonConfig($jsonConfig);
    /**
     * getToken
     * @param $key
     * @return mixed
     */
    public function getToken($key);
    /**
     * 上传文件
     * @return mixed
     */
    public function upFile($fileField);

    /**
     * 上传base64编码图片文件
     * @return mixed
     */
    public function upBase64($fileField);

    /**
     * 拉取远程图片
     * @return mixed
     */
    public function saveRemote($fileField);

    /**
     * 文件列表
     * @return mixed
     */
    public function listFile($type);

}