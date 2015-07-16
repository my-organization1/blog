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
    }

    private function saveTag($tag)
    {
        $tag = explode(',',$tag);

        $model = D('Tag');
        $map['name'] = array('in',$tag);

        $list = $model->_list($map,'id,name');
        $list = array_column($list,'id','name');

        $diff_list = array_diff($tag,$list);

        if (empty($diff_list)) {
            return $list;
        }

        $data = array();
        foreach ($diff_list as $_k => $_v) {
            $data['id'] = null;
            $data['name'] = $_v;
            $data['create_time'] = now();
            $data['modification_time'] = now();
            $data['is_enable'] = 1;
        }

        $ins = $model->addAll($data);
        return $ins;
    }

    private function saveMap($tag_id,$article_id)
    {
        if (empty($tag_id)) {
            return true;
        }
    }
}
