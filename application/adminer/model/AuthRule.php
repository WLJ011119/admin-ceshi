<?php
/**
 * Created by PhpStorm.
 * User: xiucai
 * Date: 2018/3/18
 * Time: 13:44
 */

namespace app\adminer\model;

use think\Model;

class AuthRule extends Model
{

    public static function getRuleList() {
        $res = self::order('sort', 'asc')->select()->toArray();
        return $res;
    }
}