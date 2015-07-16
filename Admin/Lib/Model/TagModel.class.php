<?php
/**
 * 文章标签Model
 *
 * @package Model
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class TagModel extends BaseModel
{
    protected $tableName = 'tag';
    protected $_validate = array(
        array('name', 'require', '请输入标签名称'),
    );

    protected $_auto = array(
        array('is_enable', 1, 1, 'string'),
        array('create_time', 'now', 1, 'function'),
        array('modification_time', 'now', 3, 'function')
    );
}