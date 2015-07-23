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

        $map = array();
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

    public function index()
    {
        $page = intval(I('page', 1));
        $page_size = intval(I('page_size'), 10);

        //查询文章表
        $model = D('Article');

        $field = 'id,catalog_id,admin_id,link_id,title,writer,source,view_count,status,create_time,modification_time';
        $map = $this->_filter();
        $list = $model->_list($map, $field, '', $page, $page_size);

        if (empty($list)) {     //没有数据则直接返回
            $this->display();
            exit();
        }

        $count = $model->_count($map);
        //分页处理
        $PageHelper  = new PageHelper($count, $page, $page_size);
        $pageList = $PageHelper->show();

        $param = array_merge($_GET, array('page'=>$page, 'page_size'=>$page_size));
        unset($param['_URL_']);

        //查询分类表
        $catalog_list = array_column($list, 'catalog_id');

        $CatalogModel = D('Catalog');
        $catalog_map['id'] = array('in', $catalog_list);
        $catalog_field = 'id,name';

        $catalog_list = $model->_list($catalog_map, $catalog_field);
        $catalog_list = array_column($catalog_list, null, 'id');

        //查询后台管理表
        $admin_list = array_column($list, 'admin_id');

        $AdminModel = D('Admin');
        $admin_map['id'] = array('in', $admin_list);
        $admin_field = 'id,username';

        $admin_list = $model->_list($admin_map, $admin_field);
        $admin_list = array_column($admin_list, null, 'id');

        //查询链接表
        $link_id = array_column($list, 'link_id');
        $link_map['id'] = array('in', $link_id);
        $link_field = 'url,link';
        $link_list = D('Link')->where($link_map, $link_field);

        //合并数据
        foreach ($list as $_k => $_v) {
            $_v = array_merge($_v, $catalog_list[$_v['catalog_id']]);
            $_v = array_merge($_v, $link_id[$_v['link_id']]);
            $list[$_k] = array_merge($_v, $admin_list[$_v['admin_id']]);
        }
        $this->assign('param', $param);
        $this->assign('page', $page);
        $this->assign('page_size', $page_size);
        $this->assign('list', $list);
        $this->assign('pageList', $pageList);
        $this->display();
    }

    public function _before_add()
    {
        $model = D('Catalog');
        $field = 'id,pid,name';
        $list = $model->_list(array(), $field, 'id asc');
        $list = ArrayHelper::tree($list);
        $this->assign('catalog_list', $list);
    }

    public function _before_edit()
    {
        $this->_before_edit();
    }

    public function save()
    {
        $model = D('Article');

        if (!$model->create()) {
            $this->error($model->getError());
        }

        $tag = I('tag', '');
        $link = I('post.link');
        if (empty($tag)) {
            $this->error('请输入文章标签');
        }
        $router_id = D('Router')->getInsId();
        $model->admin_id = 1;
        $model->router_id = $router_id;
        $model->startTrans();

        $ins = $model->add();   //写入文章表
        $add_router = $this->saveRouter($ins, $router_id, $link, 1);    //写入路由表
        $tag_id = $this->saveTag($tag);     //写入Tag表
        $save_map = $this->saveTagMap($tag_id, $ins);   //写入对应关系表

        if ($ins !== false && $tag_id !==false && $save_map !== false && $add_router !== false) {
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

        $tag = I('tag', '');
        $link = I('post.link');
        if (empty($tag)) {
            $this->error('请输入文章标签');
        }

        $map['id'] = $id;
        $router_id = $model->where($map)->getField('router_id');

        $model->startTrans();

        $ins = $model->where($map)->save();     //更新主表
        $tag_id = $this->saveTag($tag);         //更新标签表
        $save_map = $this->saveTagMap($tag_id, $id);    //更新文章标签对应表
        $update_router = $this->saveRouter($id, $router_id, $link, 2);  //更新路由表

        if ($ins !== false && $tag_id !== false && $save_map !== false && $update_router) {
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
        $tag = explode(',', $tag);

        $model = D('Tag');
        $map['name'] = array('in', $tag);

        $list = $model->_list($map, 'id,name');
        $list = array_column($list, 'name', 'id');

        $diff_list = array_diff($tag, $list);

        if (empty($diff_list)) {
            return array_keys($list);
        }

        $data = array();
        foreach ($diff_list as $_k => $_v) {
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
    private function saveTagMap($tag_id, $article_id)
    {
        $model = D('ArticleTagMap');

        $map['article_id'] = $article_id;

        $list = $model->_list($map, 'tag_id');
        $list = array_column($list, 'tag_id');
        //比较标签是否发生过更改

        $diff_list = array_diff($tag_id, $list);

        if (empty($diff_list)) {
            return true;
        }

        //删除原来的标签和文章对应关系
        $del_result = $model->where($map)->delete();

        $data = array();
        foreach ($tag_id as $_k => $_v) {
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

    /**
     * 写入路由表
     * @param  int  $article_id 文章id
     * @param  int  $router_id  路由表主键id
     * @param  string  $link    指向链接
     * @param  integer $type    类型 1-新增 2-更新
     * @return bool             成功返回true,失败返回false
     */
    private function saveRouter($article_id, $router_id, $link = '', $type = 1)
    {
        $rule = !empty($link) ? $link : 'article/'.$article_id;
        $link = 'Article/index?id='.$article_id;

        $model = D('Router');
        if ($type == 1) {
            return $model->save($rouder_id, $rule, $link);
        } else if($type == 2) {
            return $model->update($router_id, $rule, $link);
        }
    }
}
