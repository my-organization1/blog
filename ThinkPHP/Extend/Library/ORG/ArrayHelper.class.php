<?php
/**
 * 数组工具
 *
 * @package Helper
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 *
 */
class ArrayHelper
{
    /**
     * 二维数组无限分类排序
     * @method navTree
     * @param  array  $data  要排序的数组
     * @param  integer $pid   父id
     * @param  integer $level 层级,10层以后不执行循环
     * @return array         返回排序结果
     */
    public static function tree($data, $pid = 0, $level = 1)
    {
        static $list = array();

        if ($level >= 10) {
            return $list;
        }

        foreach ($data as $_k => $_v) {
            if ($_v['pid'] == $pid) {
                $list[$_k] = $_v;
                $list['_level'] = $level;
                unset($data[$_k]);
                self::tree($data, $_v['id'], $level++);
            }
        }

        return $list;
    }
}
