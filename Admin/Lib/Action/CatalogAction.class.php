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

    public function index()
    {
        $model = D('Catalog');

        $field = 'id,pid,name,link,is_show,list_tpl,content_tpl';
        $order = 'id asc';
        $list = $model->_list(array(), $field, $order);
        $list = ArrayHelper::tree($list);
        $list = array_column($list, null, 'id');

        $this->assign('list', $list);
        $this->display();
    }

    public function save()
    {
        $model = D('Catalog');

        if (!$model->create(1)) {
            $this->error($model->getError());
        }
        $name = I('post.name');
        $url = !empty(I('post.link')) ? I('post.link') : PinYin::encode($name,'all');
        $link = 'Catalog/index';

        $this->startTrans();
        $add_link = D('Link')->add($url, $link);

        $model->link_id = $add_link;
        $ins = $model->add();

        if ($add_link !== false && $ins !== false) {
            $model->commit();
            $this->success('新增成功', U('Catalog/index'));
        } else {
            if ($add_link === false) {
                $this->error('此链接已存在');
            }
            $model->rollback();
            $this->error('新增失败');
        }
    }

    public function update()
    {
        $model = D('Catalog');

        if (!$model->create(2)) {
            $this->error($model->getError());
        }
        $id = I('post.id');
        $name = I('post.name');
        $url = !empty(I('post.link')) ? I('post.link') : PinYin::encode($name,'all');

        $map['id'] = $id;

        $link_id = $model->where($map)->getField('link_id');

        $url = !empty(I('post.link')) ? I('post.link') : PinYin::encode($name,'all');
        $link = 'Catalog/index';

        $model->startTrans();

        $update_result = $model->where($map)->save();
        $update_link = D('Link')->update($link_id, $url, $link);

        if ($update_result !== false && $update_link) {
            $this->commit();
            $this->success('更新成功', U('Catalog/index'));
        } else {
            $this->rollback();
            if ($update_link === false) {
                $this->error('链接已存在');
            }
            $this->error('更新失败');
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
}
