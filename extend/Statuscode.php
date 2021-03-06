<?php
/**
 * 错误状态码定义
 * User: xiucai
 * Date: 2018/3/11
 * Time: 12:23
 */

namespace extend;


class Statuscode
{
    static $_0 = ["0", "操作成功"];
    static $_1 = ["1", "操作失败"];
    static $_2 = ["2", "验证码错误"];
    static $_3 = ["3", "用户名或密码错误"];
    static $_4 = ["4", "登陆成功"];
    static $_5 = ["5", "菜单最大层级不可超过4层"];
    static $_6 = ["6", "用户未登录"];

    static $_100 = ["100", "数据传送异常"];
    static $_101 = ["101", "服务器出现异常"];
    static $_102 = ["102", "数据获取为空"];
    static $_103 = ["103", "必填参数不能为空"];


    static $_200 = ["200", "两次密码不一致"];
    static $_201 = ["201", "密码长度不能小于6位"];
    static $_202 = ["202", "用户已存在"];

    static $_500 = ["500", "无权操作请联系超级管理"];
    static $_501 = ["501", "无权操作"];
}