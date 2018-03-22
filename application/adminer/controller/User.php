<?php
/**
 * User: William
 * Date: 2018-03-21
 * Time: 15:42
 */

namespace app\adminer\controller;

use think\Facade\Request;
use extend\Auth;

class User extends Adminbase
{
    public function index() {
        $req = Request::instance();
        $module = $req->module();
        $controller = $req->controller();
        $action = $req->action();
        $auth = new Auth();
        $res = $auth->check($module . '/' . $controller . '/' . $action, 1);
        dump($auth->getAuthList(1, 1));
    }
}