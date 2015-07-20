<?php

class LinkModel extends BaseModel
{
    protected $tableName = 'link';

    /**
     * 添加链接关系
     * @param string $url  访问的链接
     * @param string $link 指向的实际链接
     * @return  bool       更新是否成功
     */
    public function add($url, $link)
    {
        $check_result = $this->checkUrl($url);

        if ($check_result) {
            return false;
        }

        $data['url'] = $url;
        $data['link'] = $link;
        $data['create_time'] = now();
        $data['modification_time'] = now();

        $add_result = $this->add($data);

        if ($add_result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 更新链接关系
     * @param  int $id   链接表主键id
     * @param  string $url  访问的链接
     * @param  string $link 实际链接
     * @return bool       操作是否成功
     */
    public function update($id, $url, $link)
    {
        $check_result = $this->checkUrl($url, $id);
        if ($check_result) {
            return false;
        }

        $map['id'] = $id;

        $data['url'] = $url;
        $data['link'] = $link;
        $data['modification_time'] = now();

        $save_result = $this->where($map)->save($data);

        if ($save_result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 检测链接是否存在
     * @param  string $url 要检测的链接
     * @param  int $id  主键id,更新数据的时候提供
     * @return bool     存在返回true,不存在返回false
     */
    private function checkUrl($url, $id='') {
        if (!empty($id)) {
            $map['id'] = array('neq', $id);
        }

        $map['url'] = $url;

        $info = $this->where($map)->getField('id');

        if ($info) {
            return true;
        } else {
            return false;
        }
    }
}