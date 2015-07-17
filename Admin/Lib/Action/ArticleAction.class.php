<?php
/**
 * 文章管理
 *
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 *
 */
class ArticleAction extends BaseAction
{
    /**
     * 搜索条件
     * @return array 搜索条件
     */
    protected function _filter()
    {
        $param = I('post.');

        foreach ($param as $_k => $_v) {
            switch ($_k) {
                case 'catalog_id':
                case 'id':
                    $map[$_k] = intval($_v);
                    break;
                case 'title':
                    $map[$_k] = array('like', '%'.$_v.'%');
                    break;
                case 'start_time':
                    $map['create_time'] = array('lt', $_v);
                    break;
                case 'end_time':
                    $map['create_time'] = array('gt', $_v);
            }
        }

        return $map;
    }

    public function save()
    {
        $model = D('Article');

        if (!$model->create()) {
            $this->error($model->getError());
        }

        $tag = I('tag','');
        if (empty($tag)) {
            $this->error('请输入文章标签');
        }

        $model->startTrans();

        $ins = $model->add();   //写入文章表
        $tag_id = $this->saveTag($tag);     //写入Tag表
        $save_map = $this->saveTagMap($tag_id, $ins);   //写入对应关系表

        if ($ins && $tag_id && $save_map) {
            $model->commit();
            $this->success('新增成功', U('Article/index'));
        } else {
            $model->rollback();
            $this->error('新增失败');
        }
    }

    public function update()
    {
        $model = D('Article');

        if (!$model->create()) {
            $this->error($model->getError());
        }

        $id = intval(I('post.id'));
        $map['id'] = $id;

        $ins = $model->where($map)->save();
        $tag_id = $this->saveTag($tag);
        $save_map = $this->saveTagMap($tag_id, $id);

        if ($ins && $tag_id && $save_map) {
            $model->commit();
            $this->success('更新成功', U('Article/index'));
        } else {
            $model->rollback();
            $this->error('更新失败');
        }
    }
    /**
     * 保存文章标签到TAG表
     *
     * @param  string $tag 要保存的标签,逗号分隔字符串
     * @return bool|array      失败返回false,成功返回list
     *
     */
    private function saveTag($tag)
    {
        $tag = explode(',',$tag);

        $model = D('Tag');
        $map['name'] = array('in', $tag);

        $list = $model->_list($map, 'id,name');
        $list = array_column($list, 'id', 'name');

        $diff_list = array_diff($tag, $list);

        if (empty($diff_list)) {
            return array_keys($diff_list);
        }

        $data = array();
        foreach ($diff_list as $_k => $_v) {
            $_data['id'] = null;
            $_data['name'] = $_v;
            $_data['create_time'] = now();
            $_data['modification_time'] = now();
            $_data['is_enable'] = 1;
            array_push($data, $_data);
        }

        $ins = $model->addAll($data);

        if ($ins) {
            $list = $model->_list($map, 'id');
            $list = array_column($list, 'id');
            return $list;
        }
        return false;
    }

    /**
     * 将文章和标签写入对应关系表article_tag_map
     * @param  array $tag_id     标签id
     * @param  int $article_id   文章id
     * @return bool              返回执行结果
     */
    private function saveTagMap($tag_id,$article_id)
    {
        $model = D('Tag');

        $map['article_id'] = $article_id;

        $list = $model->_list($map,'tag_id');
        $list = array_column($list,'tag_id');
        //比较标签是否发生过更改
        $diff_list = array_diff($tag_id, $list);

        if (empty($diff_list)) {
            return true;
        }

        //删除原来的标签和文章对应关系
        $del_result = $model->where($map)->delete();

        $data = array();
        foreach ($tag_id as $_k => $_v) {
            $_data['id'] = null;
            $_data['tag_id'] = $_v;
            $_data['article_id'] = $article_id;
            array_push($data, $_data);
        }

        $save_result = $model->addAll($data);

        if ($save_result) {
            return true;
        }
        return false;
    }
}
