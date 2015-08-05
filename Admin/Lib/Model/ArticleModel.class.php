<?php
/**
 * 文章管理Model
 *
 * @package Model
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class ArticleModel extends BaseModel
{
    protected $tableName = 'article';

    protected $_validate = array(
        array('title', 'require', '请输入文章标题'),
        array('write', 'require', '请输入作者'),
        array('catalog_id', 'require', '请选择分类'),
        array('source', 'require', '请输入来源'),
        array('content', 'require', '请输入文章内容'),
    );

    protected $_auto = array(
        array('status', 1, 1, 'string'),
        array('admin_id', 'auto_admin_id', 3, 'callback'),
        array('create_time', 'now', 1, 'function'),
        array('modification_time', 'now', 3, 'function'),
    );

    protected function auto_admin_id()
    {
        return session('uid');
    }

    protected $_select_field = 'id,catalog_id,admin_id,router_id,title,writer,source,view_count,status,create_time,modification_time';

    /**
     * 获取文章列表数据
     * @param  array   $map       查询条件
     * @param  string  $order     排序规则
     * @param  integer $page      页数,默认1
     * @param  integer $page_size 每页条数,默认10
     * @return array              查询出的数据
     */
    public function lists($map = array(), $order = '', $page = 1, $page_size = 10)
    {
        $map = $this->_filter();
        $list = $this->_list($map, $this->_select_field, $order, $page, $page_size);

        if (empty($list)) {
            return false;
        }

        //查询分类表
        $catalog_list = array_column($list, 'catalog_id');

        $CatalogModel = D('Catalog');
        $catalog_map['id'] = array('in', $catalog_list);
        $catalog_field = 'id as catalog_id,name as catalog_name';

        $catalog_list = $CatalogModel->_list($catalog_map, $catalog_field);
        $catalog_list = array_column($catalog_list, null, 'catalog_id');

        //查询后台管理员表
        $admin_list = array_column($list, 'admin_id');

        $AdminModel = D('Admin');
        $admin_map['id'] = array('in', $admin_list);
        $admin_field = 'id as admin_id,username,nickname';

        $admin_list = $AdminModel->_list($admin_map, $admin_field);
        $admin_list = array_column($admin_list, null, 'admin_id');

        //查询链接表
        $router_id = array_column($list, 'router_id');
        $router_map['id'] = array('in', $router_id);
        $router_field = 'rule,link,id as router_id';
        $router_list = D('Router')->_list($router_map, $router_field);

        $router_list = array_column($router_list, null, 'router_id');

        //合并数据
        foreach ($list as $_k => $_v) {
            $_v = array_merge($_v, $catalog_list[$_v['catalog_id']]);
            $_v = array_merge($_v, $router_list[$_v['router_id']]);
            $list[$_k] = array_merge($_v, $admin_list[$_v['admin_id']]);
        }

        return $list;
    }

    /**
     * 根据文章id获取单条记录
     * @param  int $id    文章id
     * @return array      数据
     */
    public function get($id)
    {
        $map['id'] = $id;
        $info = $this->_get($map, $this->_select_field);

        //查询链接
        $router_map['id'] = $info['router_id'];
        $router_field = 'id as router_id,rule,link';
        $router_list = D('Router')->lists($router_map, $router_field);
        $router_list = array_column($router_list, null, 'router_id');
        //拼合数据
        $info = array_merge($info, $router_list[$info['router_id']]);

        //查询标签TagId
        $article_id = $id;
        $map['article'] = $article_id;

        $tag_id_list = D('ArticleTagMap')->_list($map, 'tag_id', 'tag_id asc');
        $tag_id_list = array_column($tag_id_list, 'tag_id');

        //查询标签名称
        $tag_map['id'] = array('in', $tag_id_list);
        $tag_map['is_enable'] = 1;
        $tag_field = 'id,name';

        $tag_list = D('Tag')->_list($tag_map, $tag_field, 'id asc');
        $tag_list = array_column($tag_list, 'name');
        $tag = implode(',', $tag_list);

        if (empty($info)) {
            return array();
        } else {
            $info['tag'] = $tag;
            return $info;
        }
    }
}
