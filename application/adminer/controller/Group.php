<?php
/**
 * Created by PhpStorm.
 * User: xiucai
 * Date: 2018/4/12
 * Time: 21:00
 */

namespace app\adminer\controller;

use think\Facade\Request;
use app\adminer\model\AuthGroup;

class Group extends Adminbase
{
    public function index() {
        if(Request::isAjax()) {
            $datas = AuthGroup::getList();
            $this->assign('datas', $datas);
            $res['count'] = AuthGroup::getCount();
            $res['data'] = AuthGroup::getList()->all();
            $res['code'] = 0;
            $res['msg'] = '';
            echo json_encode($res);
            exit;
        }

        return $this->fetch('index');
    }

    public function grantAuth() {
        if(Request::isPost()) {

        } else {
            $gid = input('gid', 0);
            $rules = AuthGroup::getRule($gid);
            $this->assign('rules', json_encode($rules));

            return $this->fetch('grant');
        }
    }
}