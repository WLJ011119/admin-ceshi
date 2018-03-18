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

class System extends Adminbase
{

    public function menuList() {
        $rule_list = AuthRule::getRuleList();

        $option = [
            'parent_key'    => 'parent_id'
        ];
        $tree = new Tree($rule_list, $option);
        $html_tree = $tree->getArray();
        $this->assign('tree', $html_tree);

        return $this->fetch('menulist');
    }
}