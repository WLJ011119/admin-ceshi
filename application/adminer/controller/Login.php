<?php
/**
 * Created by PhpStorm.
 * User: xiucai
 * Date: 2018/3/10
 * Time: 14:06
 */

namespace app\adminer\controller;

use think\Facade\Request;
use app\adminer\model\AuthUser;
use app\adminer\model\AuthRule;
use extend\PHPTree;

class Login extends Adminbase
{
    public function index() {
        // 权限列表
        $rule_tree = [];
        if($this->request->isPost()) {
            $username = Request::post('userName');
            $password = Request::post('password');
            $captcha = Request::post('captcha');
            $remember = Request::post('rememberMe');

            if(!captcha_check($captcha)) {
                $this->resultData('$_2');
            }
            $user_info = AuthUser::login($username, $password);
            if($user_info) {
                if($remember) {
                    session([
                        'expire'     => 86400,
                    ]);
                }
                $user_session_info = [
                    'id'        => $user_info['id'],
                    'username'  => $user_info['username'],
                    'super'     => $user_info['super'],
                ];
                if($user_info['super']) {
                    $rule_list = AuthRule::getRuleList();
                    $rule_tree = PHPTree::makeTree($rule_list);

                }

                session('rule_tree', $rule_tree);
                session('user_info', $user_session_info);
                $this->resultData('$_0');
            }
            $this->resultData('$_3');
        }
        return $this->fetch('index');
    }

}