<?php
/**
 * Created by PhpStorm.
 * User: xiucai
 * Date: 2018/4/12
 * Time: 21:06
 */

namespace app\adminer\model;

use think\Model;

class AuthGroup extends Model
{
    public static function getList($field='*', $where=[]) {
        $listRow = input('limit') ?: config('paginate.list_rows');
        $res = self::field($field)
            ->where(function ($query) use ($where){
            if($where) $query->where($where);
        })->paginate($listRow);
        return $res;
    }

    public static function getCount($where=[]) {
        $count = self::where(function ($query) use ($where) {
            if($where) $query->where($where);
        })->count();
        return $count;
    }
    public static function getRule($gid) {
        $res = self::table('think_auth_rule')
            ->field('id, parent_id pid, title')
            ->where('id', 'IN', function ($query) use ($gid){
                $query->table('think_auth_group')->field('rules')->where('id', $gid);
            })->select();
        return $res;
    }
}