<?php
namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;

/**
 * 用户角色模型
 * @package MyApp\Models
 */
class Roles extends Model
{
    public function validation()
    {
        $validator = new Validation();
        $validator->add('role_name', new Model\Validator\PresenceOf([
            'message' => '角色名称不能为空',
        ]));
        $validator->add('role_key', new Model\Validator\PresenceOf([
            'message' => '角色Key不能为空',
        ]));
        $validator->add('role_key', new Model\Validator\Uniqueness([
            'message' => '角色KEY已被占用',
        ]));
        return $this->validate();
    }

    /**
     * 获取select选择框数组
     * @return array
     */
    public function getSelectArray()
    {
        $findRole = self::find();
        $roleList = $findRole->toArray();
        $list = [];
        foreach ($roleList as $v) {
            $list[(int)$v['role_id']] = $v['role_name'];
        }
        return $list;
    }
}