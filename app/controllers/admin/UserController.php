<?php
namespace MyApp\Admin\Controllers;

use MyApp\Models\Roles;
use MyApp\Models\Users;

class UserController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        $this->breadcrumb[] = [
            'title' => '用户管理',
            'url'   => '',
        ];
    }

    /**
     * 个人中心
     */
    public function profileAction()
    {
        //echo "asds";
    }

    /**
     * 用户列表
     */
    public function indexAction()
    {
        //添加资源文件管理对象
        $this->assetsObj->addAssets(['DataTables','Select2','iCheck','bootstrapValidator','jquery-confirm','webuploader']);
        $totalUserCount = Users::count();
        if ($this->request->isPost() && $this->request->isAjax()) {
            //查询参数
            $parms = [];
            $draw = $this->request->get('draw', 'int');
            $start = $this->request->get('start', 'int', 0);
            $length = $this->request->get('length', 'int', 10);
            $search = $this->request->get('search', 'string');
            $keyword = $search['value'];
            $conditions = '';
            if ($keyword) {
                $parms['conditions'] = "account LIKE '%" . $keyword . "%' OR nick_name like '%" . $keyword . "%' OR email like '%" . $keyword . "%'";
            }
            $parms['columns'] = 'user_id,account,nick_name,email,user_image,active,role_id,create_at';
            $parms['order'] = 'user_id DESC';
            if ($draw) {
                $parms['offset'] = $start;
                $parms['limit'] = $length;
                $findUser = Users::find($parms);
                unset($parms['offset'], $parms['limit'], $parms['columns']);
                $recordsFiltered = Users::count($parms);
            } else {
                $findUser = Users::find($parms);
                $recordsFiltered = count($findUser);
            }
            $userList = $findUser->toArray();
            $this->msg->outputJson([
                'draw'            => (int)$draw,
                'recordsTotal'    => $totalUserCount,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $userList,
                'error'           => '',
            ]);
        }
        $this->breadcrumb[] = [
            'title' => '用户列表',
            'url'   => '',
        ];
        $this->tag->appendTitle("用户列表");
        $this->view->totalUserCount = $totalUserCount;
        //角色select数组
        $roleObj = new \MyApp\Models\Roles();
        $this->view->roleList = $roleObj->getSelectArray();
    }

    /**
     * 添加用户
     */
    public function addAction()
    {
        //添加资源文件管理对象
        $this->assetsObj->addAssets(['UEditor']);

    }

    /**
     * 编辑用户
     */
    public function editAction()
    {

    }

    /**
     * 检查帐号有效性
     */
    public function checkAccountAction()
    {
        $userId = $this->request->get('user_id', 'int');
        $account = $this->request->get('account', 'string');
        $params = [];
        if ($userId){
            $params = [
                'account=:account: AND user_id!=:user_id:',
                'bind' => ['account'=>$account,'user_id'=>$userId]
            ];
        }else{
            $params = [
                'account=:account:',
                'bind' => ['account'=>$account]
            ];
        }
        $userObj = Users::findFirst([
            'account=:account: AND user_id!=:user_id:',
            'bind' => ['account'=>$account,'user_id'=>$userId]
        ]);
        if ($userObj){
            echo json_encode(['valid' => false]);
        }else{
            echo json_encode(['valid' => true]);
        }
        exit();
    }

    /**
     * 删除用户
     */
    public function delAction()
    {
        $userId = $this->request->get('user_id', 'int');
        $userId || $this->msg->show('error', '请选择要删除的用户');
        $userObj = Users::findFirst($userId);
        $userObj !== false || $this->msg->show('error', '用户不存在');
        if ($userObj->delete() === false) {
            $messages = $userObj->getMessages();
            $this->msg->show('error', "删除失败：" . implode('<br>', $messages));
        }else{
            $this->msg->show('success', '删除成功');
        }
    }
}
