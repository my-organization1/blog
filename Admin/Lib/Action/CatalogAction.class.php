<?php
/**
 * 分类管理类
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class CatalogAction extends BaseAction
{
    public function _before_add()
    {
        $model = D('Catalog');
        $field = 'id,name';
        $order = 'id asc';
        $list = $model->_list(array(), $field, $order);
        $list = ArrayHelper::tree($list);
        //模板列表
        $tpl_list = $this->getTplList();

        $this->assign('tpl_list', $tpl_list);
        $this->assign('catalog_list', $list);
    }

    public function _before_edit()
    {
        $this->_before_add();
    }

    /**
     * 分类列表,无分页,无排序
     */
    public function index()
    {
        $model = D('Catalog');

        $field = 'id,pid,name,is_show,list_tpl,content_tpl,router_id';
        $order = 'id asc';
        $list = $model->_list(array(), $field, $order);

        //查询路由表记录
        $router_id = array_column($list, 'router_id');
        $router_field = 'id as router_id,rule,link';
        $router_map['id'] = array('in', $router_id);
        $router_list = D('Router')->lists($router_map, $router_field);
        $router_list = array_column($router_list, null, 'router_id');

        //合并数据
        foreach ($list as $_k => $_v) {
            $list[$_k] = array_merge($_v, $router_list[$_v['router_id']]);
        }

        $list = ArrayHelper::tree($list);
        $list = array_column($list, null, 'id');

        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 添加分类
     * 写入catalog表和router表
     */
    public function save()
    {
        $model = D('Catalog');

        if (!$model->create('', 1)) {
            $this->error($model->getError());
        }

        $link = I('post.link');

        //获取路由表主键id
        $router_id = D('Router')->getInsId();
        //主表补充数据
        $model->router_id = $router_id;
        $model->startTrans();

        $ins = $model->add();   //写入主表

        $inster_router = $this->saveRouter($ins, $router_id, $link, 1);     //写入路由表

        if ($inster_router !== false && $ins !== false) {
            $model->commit();
            $this->success('新增成功', U('Catalog/index'));
        } else {
            if ($inster_router === false) {
                $this->error('链接格式不正确或此链接已存在');
            }
            $model->rollback();
            $this->error('新增失败');
        }
    }

    /**
     * 更新数据
     * 更新catalog表和router表
     */
    public function update()
    {
        $model = D('Catalog');

        if (!$model->create('', 2)) {
            $this->error($model->getError());
        }
        $id = I('post.id');
        $link = I('post.link');
        $map['id'] = $id;

        $router_id = $model->where($map)->getField('router_id');    //获取路由表id

        $model->startTrans();

        $update_result = $model->where($map)->save();       //写入主表
        $update_router = $this->saveRouter($id, $router_id, $link, 2);  //写入路由表

        if ($update_router !== false && $update_result !== false) {
            $this->commit();
            $this->success('更新成功', U('Catalog/index'));
        } else {
            $this->rollback();
            if ($update_router === false) {
                $this->error('链接格式不正确或此链接已存在');
            }
            $this->error('更新失败');
        }
    }

    public function del()
    {
        $model = D('Router');
        $id = intval(I('get.id'));

        $map['id'] = $id;
        $router_id = $model->where($map)->getField('router_id');

        $model->startTrans();
        $del_router = D('Router')->delete($router_id);
        $del_result = $model->delete($id);

        if ($del_router !== false && $del_result !== false) {
            $model->commit();
            $this->success('删除成功', U('Catalog/index'));
        } else {
            $model->rollback();
            $this->error('删除失败');
        }
    }

    /**
     * 获取模板列表
     * 目前只读取一层,路径为./Template/指定模板主题
     * @method getTplList
     * @return array     模板文件列表
     */
    private function getTplList()
    {
        $tpl_path = './Template/'.C('APP_DEFAULT_THEME').'/';
        $file_list = scandir($tpl_path);
        unset($file_list[0],$file_list[1]);

        foreach ($file_list as $_k => $_v) {
            $pathinfo = pathinfo($_v);
            if ($pathinfo['extension'] !== 'html') {
                unset($file_list[$_k]);
            } else {
                $file_list[$_k] = $pathinfo['filename'];
            }
        }

        return $file_list;
    }

    /**
     * 写入路由表
     * @param  int  $catalog_id 分类id
     * @param  int  $router_id  路由表主键id
     * @param  string  $link    指向链接
     * @param  integer $type    类型 1-新增 2-更新
     * @return bool             成功返回true,失败返回false
     */
    private function saveRouter($catalog_id, $router_id, $link = '', $type = 1)
    {
        $rule = !empty($link) ? $link : 'catalog/'.$catalog_id;
        $link = 'Catalog/index?id='.$catalog_id;

        $model = D('Router');
        if ($type == 1) {
            return $model->save($router_id, $rule, $link);
        } else if($type == 2) {
            return $model->update($router_id, $rule, $link);
        }
    }
}
