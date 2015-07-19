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
