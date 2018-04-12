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
    /**
     * 登陆
     * @param $usename
     * @param $password
     * @return bool|null|static
     */
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

    /**
     * 获取成员列表
     * @param string $field
     * @param array $where
     * @return \think\Paginator
     */
    public static function getList($field='*', $where=[]) {
        $listRow = input('limit') ?: config('paginate.list_rows');
        $res = self::field($field)
            ->where(function ($query) use ($where){
                if($where) $query->where($where);
            })->paginate($listRow);
        return $res;
    }

    /**
     * 统计成员数量
     * @param array $where
     * @return int|string
     */
    public static function getCount($where=[]) {
        $count = self::where(function ($query) use ($where) {
            if($where) $query->where($where);
        })->count();
        return $count;
    }
}