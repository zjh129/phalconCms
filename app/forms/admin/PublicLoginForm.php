<?php
namespace MyApp\Admin\Forms;
/**
 * Created by PhpStorm.
 * User: qianxun
 * Date: 16-10-17
 * Time: 下午5:30
 */
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;

/**
 * 用户登录表单
 * @package MyApp\Admin\Forms
 */
class PublicLoginForm extends Form
{
    public function initialize($entity = null, $options = [])
    {
        $account = new Text('account');
        $account->setLabel('账号:');
        $account->setAttributes(['class'=>'form-control','placeholder'=>'账号']);
        $account->setUserOption('icon', '<span class="glyphicon glyphicon glyphicon-user form-control-feedback"></span>');
        $account->setFilters(['striptags', 'string']);
        $account->addValidators([
            new PresenceOf(['message' => '账号必填']),
        ]);
        $this->add($account);

        $password = new Password('password');
        $password->setLabel('密码：');
        $password->setAttributes(['class'=>'form-control','placeholder'=>'密码']);
        $password->setUserOption('icon', '<span class="glyphicon glyphicon-lock form-control-feedback"></span>');
        $password->setFilters(['striptags', 'string']);
        $password->addValidators([
            new Regex([
                'pattern' => '/^[\\~!@#$%^&*()-_=+|{}\[\],.?\/:;\'\"\d\w]{6,}$/',
                'message' => '密码至少包含六个字符',
            ])
        ]);
        $this->add($password);

        $captcha = new Text('captcha');
        $captcha->setLabel('验证码:');
        $captcha->setAttributes(['class'=>'form-control','placeholder'=>'验证码']);
        $captcha->setUserOption('icon', '<span class="glyphicon glyphicon-eye-open form-control-feedback"></span>');
        $captcha->setFilters(['striptags','string']);
        $captcha->clear();
        $captcha->addValidators([
            new PresenceOf(['message' => '验证码必填']),
        ]);
        $this->add($captcha);

    }
}