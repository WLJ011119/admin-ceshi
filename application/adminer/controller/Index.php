<?php
namespace app\adminer\controller;


class Index extends Adminbase
{
    public function index()
    {
        return $this->fetch();
    }

    public function welcome() {
        $sys_info = [
            'PHP版本'     => PHP_VERSION,
            'ZEND版本'    => zend_version(),
            'MySQL版本'   => db()->query('select version() version')[0]['version'],
            '域名'        => $_SERVER['SERVER_NAME'],
            '端口'        => $_SERVER['SERVER_PORT'],
            'IP'          => $_SERVER['SERVER_ADDR'],
            'WEB服务'     => $_SERVER['SERVER_SOFTWARE'],
            '操作系统'    => PHP_OS,
            'MySQL最大连接数'    => db()->query("show variables like '%max_connections%'")[0]['Value'],
            '文件上传大小'=> get_cfg_var ("upload_max_filesize") ?: "不允许上传附件",
            '最大执行时间'=> get_cfg_var("max_execution_time") ? get_cfg_var("max_execution_time")."秒": "无限制",
            '系统当前时间'=> date("Y-m-d H:i:s"),
        ];

        $this->assign('sys_info', $sys_info);
        return $this->fetch('welcome');
    }
}
