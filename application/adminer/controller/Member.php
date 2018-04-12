<?php
/**
 * User: William
 * Date: 2018-03-21
 * Time: 15:42
 */

namespace app\adminer\controller;

use think\Facade\Request;
use app\adminer\model\AuthUser;

class Member extends Adminbase
{
    public function index() {
        if(Request::isAjax()) {
            $res['count'] = AuthUser::getCount();
            $res['data'] = AuthUser::getList('id,username,status,remark,create_at')->all();
            $res['code'] = 0;
            $res['msg'] = '';
            echo json_encode($res);
            exit;
        }

        return $this->fetch('index');
    }

    public function grantAuth() {

    }
}