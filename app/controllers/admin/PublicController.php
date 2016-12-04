<?php
namespace MyApp\Admin\Controllers;

use MyApp\Models\Users;
use Phalcon\Mvc\View;
use MyApp\Admin\Forms\PublicLoginForm;

class PublicController extends BaseController
{
    /**
     * 登陆控制器
     */
    public function loginAction()
    {
        $form = new PublicLoginForm();
        if ($this->request->isPost()) {
            $captcha = $this->request->getPost('captcha', 'string');
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }
            $account = $this->request->getPost('account', 'string');
            $password = $this->request->getPost('password', 'string');
            if ($account && $password && $captcha) {
                $acaptcha = new \MyApp\Library\XCaptcha;
                $checkCode = $acaptcha->checkCode($captcha);
                if (!$checkCode) {
                    $this->flash->error('验证码不正确！');
                } else {
                    $findUser = Users::findFirst(['account' => $account]);
                    $userInfo = $findUser->toArray();
                    //var_dump($this->security->hash($password));exit();
                    if ($userInfo && $this->security->checkHash($password, $userInfo['password'])) {
                        //用户session KEY
                        $userKey = $this->config->session->adminUserKey;
                        //清除密码信息
                        unset($userInfo['password']);
                        $this->session->set($userKey, $userInfo);
                        //echo json_encode($userInfo);
                        // 使用直接闪存
                        $this->flash->success("登录成功");
                        // 跳转到首页
                        return $this->response->redirect("index/index");
                    } else {
                        $this->flash->error('用户名或密码错误!');
                    }
                }
            }
        }
        $this->view->setVar('form', $form);
        $this->tag->appendTitle("登录");
        //关闭渲染级别
        $this->view->disableLevel([
            View::LEVEL_LAYOUT      => true,
            View::LEVEL_MAIN_LAYOUT => true,
        ]);
    }

    /**
     * 验证码
     */
    public function captchaAction()
    {
        $acaptcha = new \MyApp\Library\XCaptcha;
        $acaptcha->entryCode();
        $this->view->disable();
    }

    /**
     * 退出登录
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function logoutAction()
    {
        //用户session KEY
        $userKey = $this->config->session->adminUserKey;
        //移除session
        $this->session->remove($userKey);
        // 跳转到首页
        $this->response->redirect("public/login");
    }
}
