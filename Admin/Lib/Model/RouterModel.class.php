<?php
/**
 * 路由Model
 *
 * @package Model
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class RouterModel extends BaseModel
{
    protected $tableName = 'router';

    public function save($id, $rule, $link)
    {
        //检测路由格式
        if (!$this->checkRuleFormat($rule)) {
            return false;
        }
        $rule = addcslashes($rule, '/');
        $rule = '/^'.$rule.'$/';

        if ($this->checkRule($rule)) {
            return false;
        }

        $data['id'] = $id;
        $data['rule'] = $rule;
        $data['link'] = $link;
        $data['create_time'] = now();
        $data['modification_time'] = now();

        $ins = $this->add($data);

        return $ins;
    }

    public function update($id, $rule, $link)
    {
        $map['id'] = $id;

        $data['rule'] = $rule;
        $data['link'] = $link;
        $data['modification_time'] = now();

        $save = $this->where($map)->save($data);

        return $ins;
    }


    /**
     * 获取即将插入的主键id
     * @return int id
     */
    public function getInsId()
    {
        $sql = 'SHOW TABLE STATUS LIKE \''.C('DB_PREFIX').'router\'';
        $info = $this->query($sql);
        return $info[0]['Auto_increment'] ? $info[0]['Auto_increment'] : 1;
    }

    /**
     * 监测路由是否已存在
     * @param  string $rule 路由
     * @return bool       存在返回true，不存在返回false
     */
    private function checkRule($rule)
    {
        $map['rule'] = $rule;

        $info = $this->where($map)->getField('id');

        if ($info) {
            return true;
        } else {
            return false;
        }
    }

    private function checkRuleFormat($rule)
    {
        $rootDirList = scandir('.');
        if (in_array($rule, $rootDirList)) {
            return false;
        }
        return ture;
    }
}
