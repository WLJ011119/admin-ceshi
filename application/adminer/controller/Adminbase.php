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
use think\Controller;

class Adminbase extends Controller
{
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
}