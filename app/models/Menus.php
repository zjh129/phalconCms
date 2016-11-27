<?php
namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;

/**
 * 菜单模型
 * @package MyApp\Models
 */
class Menus extends Model
{
    public function validate()
    {
        $validator = new Validation();
        $validator->add('module_name', new Model\Validator\PresenceOf([
            'message' => '请输入模块名',
        ]));
        $validator->add('resource_id', new Model\Validator\PresenceOf([
            'message' => '请绑定资源名称',
        ]));
    }
}