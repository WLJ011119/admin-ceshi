<?php
/**
 * Created by PhpStorm.
 * User: xiucai
 * Date: 2018/3/10
 * Time: 14:03
 */

namespace app\adminer\controller;

use think\Facade\Request;
use think\Facade\Response;
use think\Facade\Config;
use think\Controller;

class Adminbase extends Controller
{
    protected $userInfo;

    public function initialize() {
        $this->tologin();
        $authConf = Config::pull('auth');
        if(isset($authConf['auth_menu']) && $authConf['auth_menu']) {
            $this->assignRuleTree();
        } else {
            $this->assignUserRuleTree();
        }
    }

    /**
     * 判断是否登陆
     */
    public function tologin() {
        $this->getUserInfo();
        $reqobj = Request::instance();
        $module = $reqobj->module();            // 模块
        $controller = $reqobj->controller();    // 控制器
        $action = $reqobj->action();            // 方法
        // 完整的url中path部分
        $path = strtolower($module . '/' . $controller . '/' . $action);
        // 登陆链接的path
        $login_path = 'adminer/login/index';
        if(empty($this->userInfo) && $path != $login_path) {
            $this->redirect('/login');
        }
    }

    /**
     * 获取登陆用户信息
     */
    public function getUserInfo() {
        $this->userInfo = session('user_info');
    }

    /**
     * 用户权限数组分配给模板
     * @param array $ruleTree
     */
    public function assignUserRuleTree() {
        $ruleTree = [];
        $uid = $this->userInfo['id'];
        $this->assign('rule_tree', $ruleTree);
    }

    /**
     * 分配所有权限数组给模板
     */
    public function assignRuleTree() {
        $rule_list = \app\adminer\model\AuthRule::getRuleList();
        $rule_tree = \extend\PHPTree::makeTree($rule_list);
        $this->assign('rule_tree', $rule_tree);
    }
    /**
     * 格式化返回数据
     * @param array $data   数据
     * @param array $code   错误代码数组
     * @return mixed
     */
    public function resultData($code = ["0", "操作成功"], $data = [], $type = 'array'){
        if (is_string($code)) {
            @eval('$code = \\extend\\Statuscode::' . $code . ';');
        }
        $requestObj = Request::instance();   // 获取 模块/控制器/操作名称
        $module = $requestObj->module();
        $controller = $requestObj->controller();
        $action = $requestObj->action();
        $result['cmd'] = $module.'/'.$controller.'/'.$action;    //接口名称
        $result['errCode'] = $code[0];
        $result['msg'] = $code[1];
        if ($type == 'array' && !is_array($data)) {
            $data = [];
        } elseif ($type == 'string') {
            $result['msg'] .=', '. $data;
            $data = [];
        } elseif (!in_array($type, ['array', 'string'])) {
            $data = [];
        }
        $result['detail'] = $data;

        Response::create($result,'json')->send();
        exit;
    }

    /**
     * 检验指定参数是否存在或有效
     * @param array $data
     */
    protected function checkParams($data = []) {
        $arr = func_get_args();
        if (count($arr) == 1) {
            $arr = (array) $data;
        }
        foreach ($arr as $v) {
            if (strpos($v, '|') === false) {
                $name = $v;
                $filter = '';
            } else {
                list($name, $filter) = explode('|', $v);
            }
            $tmp = input('param.' . $name, '', $filter);
            if (!$tmp) {
                return false;
            }
        }
        return true;
    }
}