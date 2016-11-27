<?php
namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;

/**
 * 用户模型
 * @package MyApp\Models
 */
class Users extends Model
{
    public function validation()
    {
        $validator = new Validation();
        $validator->add('email', new EmailValidator([
            'message' => '邮箱格式无效',
        ]));
        $validator->add('email', new UniquenessValidator([
            'message' => '抱歉，邮箱已被其他人注册',
        ]));
        $validator->add('account', new UniquenessValidator([
            'message' => '抱歉，该账号被占用',
        ]));
    }
}