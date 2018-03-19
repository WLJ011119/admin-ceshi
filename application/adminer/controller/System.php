<?php
/**
 * Created by PhpStorm.
 * User: xiucai
 * Date: 2018/3/18
 * Time: 17:52
 */

namespace app\adminer\controller;

use extend\Tree;
use app\adminer\model\AuthRule;
use think\facade\Request;
use think\facade\Response;
use extend\PHPTree;

class System extends Adminbase
{

    public function menuList() {
        if(Request::instance()->isAjax()) {
            $rule_list = AuthRule::getRuleList();
            $option = [
                'parent_key'    => 'parent_id',
                'menu_name'     => 'title',
            ];
            $tree = new Tree($rule_list, $option);
            $html_tree = $tree->getArray();
            $data = [
                'code'      => 0,
                'msg'       => '',
                'count'     => 1000,
                'data'      => $html_tree,
            ];
            Response::create($data, 'json')->send();
            exit;
        }
//        dump(PHPTree::makeTree(AuthRule::getRuleList()));
        return $this->fetch('menulist');
    }
}