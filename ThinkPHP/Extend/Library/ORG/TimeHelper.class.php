<?php
/**
 * 时间辅助工具
 *
 * @package Helper
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 *
 */

class TimeHelper
{
    /**
     * 获取当前时间的表现形式
     * @method now
     * @return [type] [description]
     */
    public static function now($format = 'Y-m-d H:i:s')
    {
        return date($format, time());
    }
}
