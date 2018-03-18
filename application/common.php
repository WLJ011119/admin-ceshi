<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use think\facade\Env;

/**
 * 日志打印
 * @param mixed     $input      被打印的数据
 * @param string    $filepath   日志路径
 * @param bool      $clean      打印前是否清除文件
 */
function dbg($input, $filepath = '', $clean = false) {
    if(is_array($input)) {
        $input = var_export($input, true);
    }
    if(is_object($input)) {
        $input = var_export((array)$input, true);
    }
    if(empty($filepath)) {
        $filepath = Env::get('RUNTIME_PATH') .'dbg' . DIRECTORY_SEPARATOR . date("Y-m-d") . '.txt';
    }
    if(!file_exists(dirname($filepath))) {
        mkdir(dirname($filepath), 0644, true);
    }
    if($clean) {
        file_put_contents($filepath, $input . PHP_EOL);
    } else {
        file_put_contents($filepath, $input . PHP_EOL, FILE_APPEND);
    }
}