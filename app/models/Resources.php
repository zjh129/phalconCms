<?php
namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;

/**
 * 访问资源类别
 * @package MyApp\Models
 */
class Resources extends Model
{
    public function validate()
    {
        $validator = new Validation();
        $validator->add('module_name', new Model\Validator\PresenceOf([
            'message' => '请输入资源所属模块',
        ]));
        $validator->add('resource_name', new Model\Validator\PresenceOf([
            'message' => '请输入资源名称',
        ]));
        $validator->add('resource_key', new Model\Validator\PresenceOf([
            'message' => '请输入资源key',
        ]));
        $validator->add('type', new Model\Validator\Inclusionin([
            'domain'  => [1, 2],
            'message' => '请选择资源类别',
        ]));
    }
}