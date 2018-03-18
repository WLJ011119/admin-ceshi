<?php
/**
 * Created by PhpStorm.
 * User: xiucai
 * Date: 2018/3/17
 * Time: 12:32
 */

namespace app\adminer\model;

use think\Model;

class AuthUser extends Model
{
    public static function login($usename, $password) {
        $user_info = self::get(['username'=>$usename]);
        if($user_info['username'] !== $usename) {
            return false;
        }
        if(md5($password . $user_info['salt']) != $user_info['password']) {
            return false;
        }
        return $user_info;
    }

}