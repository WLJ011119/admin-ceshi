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

    static $_100 = ["100", "数据传送异常"];
    static $_101 = ["101", "服务器出现异常"];
    static $_102 = ["102", "数据获取为空"];
}