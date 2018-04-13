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
    /**
     * 角色列表
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
     * 角色数量统计
     * @param array $where
     * @return int|string
     */
    public static function getCount($where=[]) {
        $count = self::where(function ($query) use ($where) {
            if($where) $query->where($where);
        })->count();
        return $count;
    }

    /**
     * 角色拥有的节点
     * @param $gid
     * @return false|static[]
     */
    public static function getRule($gid) {
        // 所有节点
        $allRule = self::field('id, parent_id pId, title name')
            ->table('think_auth_rule')
            ->select();
        // 角色拥有的节点
        $res = self::field('rules')
            ->where('id', $gid)
            ->find();
        $groupRule = explode(',', $res['rules']);
        foreach ($allRule as $key => $rule) {
            if(in_array($rule['id'], $groupRule)) {
                $allRule[$key]['checked'] = true;
            }
        }
        return $allRule;
    }
}