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

/**
 * 生成各种码
 * @param int $nums             生成多少个优惠码
 * @param array $exist_array    排除指定数组中的优惠码
 * @param int $code_length      生成优惠码的长度
 * @param int $prefix           生成指定前缀
 * @return array                返回优惠码数组
 */
function generateCode( $nums,$exist_array=[],$code_length = 6,$prefix = '' ) {
    $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $promotion_codes = array();//这个数组用来接收生成的优惠码

    for($j = 0 ; $j < $nums; $j++) {
        $code = '';
        for ($i = 0; $i < $code_length; $i++) {
            $code .= $characters[mt_rand(0, strlen($characters)-1)];
        }

        //如果生成的4位随机数不再我们定义的$promotion_codes数组里面
        if( !in_array($code,$promotion_codes) ) {
            if( is_array($exist_array) ) {
                if( !in_array($code,$exist_array) ) {//排除已经使用的优惠码
                    $promotion_codes[$j] = $prefix.$code; //将生成的新优惠码赋值给promotion_codes数组
                } else {
                    $j--;
                }
            } else {
                $promotion_codes[$j] = $prefix.$code;//将优惠码赋值给数组
            }
        } else {
            $j--;
        }
    }
    return $promotion_codes;
}

/**
 * 生成二维码图片,下载地址https://sourceforge.net/projects/phpqrcode/files/
 * @param string $content   内容
 * @param string $qr        二维码地址
 * @param string $logo      logo地址
 * @param string $level     容错等级
 * @param string $size      图片大小
 * @return string
 */
function qr($content='', $qr='', $logo='', $level='L', $size='6') {
    if(empty($content)) {
        return 'content is not empty';
    }
    \think\Loader::import('phpqrcode.phpqrcode', EXTEND_PATH);
    if(empty($qr)) {
        $path = Env::get('ROOT_PATH') . "public/static/"; // 本地存放图片路径
        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $qr = $path . time() . '.png';
    }
    QRcode::png($content, $qr, $level, $size, 2);
    if($logo) {
        if(file_exists($logo)) {
            $logo_resource = imagecreatefromstring(file_get_contents($logo));
            $qrcode_resource = imagecreatefromstring(file_get_contents($qr));
            $logo_w = imagesx($logo_resource);   // logo图片宽度
            $logo_h = imagesy($logo_resource);   // logo图片高度
            $qrcode_w = imagesx($qrcode_resource); // 二维码图片宽度
            $logo_qr_width = $qrcode_w / 5;
            $scale = $logo_w / $logo_qr_width;
            $logo_qr_height = $logo_h / $scale;
            $from_width = ($qrcode_w - $logo_qr_width) / 2;
            // 重新组合图片并调整大小
            imagecopyresampled($qrcode_resource, $logo_resource, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_w, $logo_h);
            imagepng($qrcode_resource, $qr);
        } else {
            return 'logo file is not exist';
        }
    }
    return $qr;
}

/**
 * 字符串加密
 * @param $str
 * @return string
 */
function base64_en($str) {
    $str = base64_encode($str);
    $str .= randStr(5);
    $str = base64_encode($str);
    $str = randStr(3) . $str;
    return $str;
}

/**
 * 字符串解密
 * @param $str
 * @return bool|string
 */
function base64_de($str) {
    $len = strlen($str);
    $str = substr($str, 3, $len - 2);
    $str = base64_decode($str);
    $str = substr($str, 0, -5);
    $str = base64_decode($str);
    return $str;
}

/**
 * 返回指定长度的随机字符
 * @param $len
 * @return bool|string
 */
function randStr($len) {
    $str = "ABCDEFGHIJKLMNOPQRSTUVWSYZabcdefghijklmnopqrstuvwsyz0123456789";
    return substr(str_shuffle($str), 0, $len);
}

/**
 * 数组转xls格式的excel文件
 * @param  array  $data      需要生成excel文件的数组
 * @param  string $filename  生成的excel文件名
 *      示例数据：
$data = array(
array(NULL, 2010, 2011, 2012),
array('Q1',   12,   15,   21),
array('Q2',   56,   73,   86),
array('Q3',   52,   61,   69),
array('Q4',   30,   32,    0),
);
 */
function create_xls($data,$filename='simple.xls'){
    ini_set('max_execution_time', '0');
    Vendor('PHPExcel.PHPExcel');
    $filename=str_replace('.xls', '', $filename).'.xls';
    $phpexcel = new PHPExcel();
    $phpexcel->getProperties()
        ->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $phpexcel->getActiveSheet()->fromArray($data);
    $phpexcel->getActiveSheet()->setTitle('Sheet1');
    $phpexcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=$filename");
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0
    $objwriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
    $objwriter->save('php://output');
    exit;
}
/**
 * 数据转csv格式的excle
 * @param  array $data      需要转的数组
 * @param  string $header   要生成的excel表头
 * @param  string $filename 生成的excel文件名
 * 示例数组：
$data = array(
'1,2,3,4,5',
'6,7,8,9,0',
'1,3,5,6,7'
);
$header='用户名,密码,头像,性别,手机号';
 */
function create_csv($data,$header=null,$filename='simple.csv'){
    // 如果手动设置表头；则放在第一行
    if (!is_null($header)) {
        array_unshift($data, $header);
    }
    // 防止没有添加文件后缀
    $filename=str_replace('.csv', '', $filename).'.csv';
    ob_clean();
    Header( "Content-type:  application/octet-stream ");
    Header( "Accept-Ranges:  bytes ");
    Header( "Content-Disposition:  attachment;  filename=".$filename);
    foreach( $data as $k => $v){
        // 如果是二维数组；转成一维
        if (is_array($v)) {
            $v=implode(',', $v);
        }
        // 替换掉换行
        $v=preg_replace('/\s*/', '', $v);
        // 解决导出的数字会显示成科学计数法的问题
        $v=str_replace(',', "\t,", $v);
        // 转成gbk以兼容office乱码的问题
        echo iconv('UTF-8','GBK',$v)."\t\r\n";
    }
}
/**
 * 导入excel文件
 * @param  string $file excel文件路径
 * @return array        excel文件内容数组
 */
function import_excel($file){
    // 判断文件是什么格式
    $type = pathinfo($file);
    $type = strtolower($type["extension"]);
    if ($type=='xlsx') {
        $type='Excel2007';
    }elseif($type=='xls') {
        $type = 'Excel5';
    }
    ini_set('max_execution_time', '0');
    Vendor('PHPExcel.PHPExcel');
    // 判断使用哪种格式
    $objReader = PHPExcel_IOFactory::createReader($type);
    $objPHPExcel = $objReader->load($file);
    $sheet = $objPHPExcel->getSheet(0);
    // 取得总行数
    $highestRow = $sheet->getHighestRow();
    // 取得总列数
    $highestColumn = $sheet->getHighestColumn();
    //总列数转换成数字
    $numHighestColum = PHPExcel_Cell::columnIndexFromString("$highestColumn");
    //循环读取excel文件,读取一条,插入一条
    $data=array();
    //从第一行开始读取数据
    for($j=1;$j<=$highestRow;$j++){
        //从A列读取数据
        for($k=0;$k<=$numHighestColum;$k++){
            //数字列转换成字母
            $columnIndex = PHPExcel_Cell::stringFromColumnIndex($k);
            // 读取单元格
            $data[$j][]=$objPHPExcel->getActiveSheet()->getCell("$columnIndex$j")->getValue();
        }
    }
    return $data;
}

/**
 * 打乱数组,保持键值对关系
 * @param array  $array
 * @return array
 */
function shuffle_assoc($array) {
    if (!is_array($array) || empty($array)) return $array;

    $keys = array_keys($array);
    shuffle($keys);
    $random = array();
    foreach ($keys as $key){
        $random[$key] = $array[$key];
    }
    return $random;
}

/**
 * 手机号打码
 * @param mixed    $num     手机号码
 * @return string
 */
function phoneNumMosaic($num) {
    if(!preg_match('/\d{11}/', $num)) {
        return $num;
    }
    $str_1 = substr($num, 0,3);
    $str_2 = substr($num, -4, strlen($num));
    return $str_1 . '***' . $str_2;
}