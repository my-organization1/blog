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
                    $map[$_k] = array('like', '%' . $_v . '%');
                    break;
            }
        }
        //开始时间和结束时间的判断
        if (isset($param['start_time']) && isset($param['end_time'])) {
            $map['create_time'] = array('between', array($param['start_time'], $param['end_time']));
        } else if (isset($param['start_time'])) {
            $map['create_time'] = array('gt', $param['start_time']);
        } else if (isset($param['end_time'])) {
            $map['create_time'] = array('lt', $param['end_time']);
        }
        return $map;
    }

    /**
     * 文章列表
     */
    public function index()
    {
        $page = intval(I('page', 1));
        $page_size = intval(I('page_size', 10));

        //查询文章表
        $model = D('Article');

        $map = $this->_filter();

        $list = $model->lists($map, '', $page, $page_size);

        if (empty($list)) {
            //没有数据则直接返回
            $this->display();
            exit();
        }

        $count = $model->_count($map);
        //分页处理
        $PageHelper = new PageHelper($count, $page, $page_size);
        $pageList = $PageHelper->show();

        $param = array_merge($_GET, array('page' => $page, 'page_size' => $page_size));
        unset($param['_URL_']);

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
        $this->_before_add();
    }

    /**
     * 编辑文章
     */
    public function edit()
    {
        $id = I('get.id');

        $model = D('Article');

        $info = $model->get($id);

        $this->assign('vo', $info);
        $this->display();
    }

    /**
     * 新增文章
     * 保存到文章表,路由表,TAG表,TAG-ARTICLE对应表
     * @method save
     */
    public function save()
    {
        $model = D('Article');

        if (!$model->create()) {
            $this->error($model->getError());
        }

        $tag = I('tag', '');
        $link = I('post.link');
        $content = I('post.content');
        if (empty($tag)) {
            $this->error('请输入文章标签');
        }

        $router_id = D('Router')->getInsId();
        $model->admin_id = 1;
        $model->router_id = $router_id;
        $model->description = !empty(strip_tags($content)) ? msubstr(strip_tags($content), 0, 200) : null;
        $model->startTrans();

        $ins = $model->add(); //写入文章表

        $add_router = $this->saveRouter($ins, $router_id, $link, 1); //写入路由表
        $tag_id = $this->saveTag($tag); //写入Tag表
        $save_map = $this->saveTagMap($tag_id, $ins); //写入对应关系表

        if ($ins !== false && $tag_id !== false && $save_map !== false && $add_router !== false) {
            $model->commit();
            $this->success('新增成功', U('Article/index'));
        } else {
            $model->rollback();
            if ($tag_id === false) {
                $this->error('新增Tag失败');
            } else if ($save_map === false) {
                $this->error('保存Tag失败');
            } else if ($add_router) {
                $this->error('访问链接已存在,请换一个新链接');
            } else {
                $this->error('新增失败');
            }
        }
    }

    /**
     * 更新文章表
     *保存到文章表,路由表,TAG表,TAG-ARTICLE对应表
     * @method update
     */
    public function update()
    {
        $model = D('Article');

        if (!$model->create()) {
            $this->error($model->getError());
        }
        $id = I('post.id');
        $tag = I('tag', '');
        $link = I('post.link');
        $content = strip_html(htmlspecialchars_decode(I('post.content')));
        if (empty($tag)) {
            $this->error('请输入文章标签');
        }

        $map['id'] = $id;
        $router_id = $model->where($map)->getField('router_id');

        $model->description = !empty($content) ? msubstr($content, 0, 200) : null; //补充描述

        $model->startTrans();

        $ins = $model->where($map)->save(); //更新主表

        $tag_id = $this->saveTag($tag); //更新标签表
        $save_map = $this->saveTagMap($tag_id, $id); //更新文章标签对应表
        $update_router = $this->saveRouter($id, $router_id, $link, 2); //更新路由表

        if ($ins !== false && $tag_id !== false && $save_map !== false && $update_router !== false) {
            $model->commit();
            $this->success('更新成功', U('Article/index'));
        } else {
            $model->rollback();
            if ($tag_id === false) {
                $this->error('更新Tag失败');
            } else if ($save_map === false) {
                $this->error('无法建立文章和Tag对应关系');
            } else if ($update_router) {
                $this->error('访问链接已存在,请换一个新链接');
            } else {
                $this->error('更新失败');
            }
        }
    }

    /**
     * 删除文章
     * 同时删除路由表,删除标签文章对应表
     * @method del
     */
    public function del()
    {
        $id = I('get.id');
        $map['id'] = $id;

        $model = D('Article');

        $info = $model->_get($map);

        $model->startTrans(); //开启事务

        $del_article = $model->delete($id); //删除文章表

        $del_router = D('Router')->where(array('id' => $info['router_id']))->delete(); //删除路由表

        $del_map = D('ArticleTagMap')->where(array('article_id' => $id))->delete(); //删除标签文章对应表

        if ($del_article !== false && $del_router !== false && $del_map !== false) {
            $model->commit();
            $this->success('删除成功', U('Article/index'));
        } else {
            $model->rollback();
            $this->error('删除失败');
        }
    }

    /**
     * 更新文章状态
     */
    public function Status()
    {
        $id = I('id');
        $status = I('status', 0);

        $map['id'] = $id;
        $data['status'] = $status;
        $result = D('Article')->where($map)->save($data);

        if ($result) {
            $this->success('更新状态成功', U('Article/index'));
        } else {
            $this->error('更新状态失败');
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
        $rule = !empty($link) ? $link : 'article/' . $article_id;
        $link = 'Article/index?id=' . $article_id;

        $model = D('Router');
        if ($type == 1) {
            return $model->add($router_id, $rule, $link);
        } else if ($type == 2) {
            return $model->update($router_id, $rule, $link);
        }
    }
}
