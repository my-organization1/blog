<?php
/**
 * 统计Action
 *
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class StateAction extends BaseAction
{
    protected function _filter()
    {
        $param = I('post.');

        foreach ($param as $_k => $_v) {
            switch ($_k) {
                case 'link':
                case 'ip':
                    $map[$_k] = array('like', '%'.$_v.'%');
                    break;
            }
        }

        return $map;
    }
}