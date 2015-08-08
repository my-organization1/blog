<?php

class ArticleModel extends BaseModel
{
    /**
     * 获取文章列表根据分类id
     * @param  int  $catalog_id 分类id
     * @param  string  $order      排序规则
     * @param  integer $page       分页数
     * @param  integer $page_size  每页条数
     * @return array               查询出来的数据
     */
    public function listsByCatalogId($catalog_id = '', $order = '', $page = 1, $page_size = 10)
    {
        if (!empty($catalog_id)) {
            $map['catalog_id'] = $catalog_id;
        }

        return $this->lists($map, $order, $page, $page_size);
    }
    /**
     * 获取文章列表
     * @param  array  $map 查询条件
     * @param  string  $order      排序规则
     * @param  integer $page       分页数
     * @param  integer $page_size  每页条数
     * @return array               查询出来的数据
     */
    public function lists($map = array(), $order = '', $page = 1, $page_size = 10)
    {

        $order = empty($order) ? 'create_time desc' : $order ;
        $field = 'id,catalog_id,router_id,title,description,writer,source,view_count,thumb,create_time';

        $list = $this->_list($map, $field, $order, $page, $page_size);

        if (empty($list)) {
            return array();
        }
        //处理缩略图
        foreach ($list as $_k => $_v) {
            if (empty($_v['thumb']) || !is_file($_v['thumb'])) {
                $list[$_k]['thumb'] = TMPL_PATH.'/'.C('APP_DEFAULT_THEME').'/images/default-thumb.jpg';
            }
        }
        //文章访问路由
        $router_id = array_column($list, 'router_id');

        $router_list = D('Router')->lists($router_id);

        foreach ($list as $_k => $_v) {
            $list[$_k] = array_merge($_v, $router_list[$_v['router_id']]);
        }

        return $list;
    }

    /**
     * 根据文章id获取文章详情
     * @param  int $id 文章id
     * @return array     查询到的数据
     */
    public function get($id, $order = '')
    {
        if (is_numeric($id)) {
            $map['id'] = $id;
        } else {
            $map = $id;
        }

        $field = 'id,catalog_id,router_id,title,description,content,writer,source,view_count,thumb,create_time';

        $article_info = $this->_get($map, $field, $order);

        if (empty($article_info)) {
            return array();
        }
        //查询路由信息
        $router_id[] = $article_info['router_id'];

        $router_list = D('Router')->lists($router_id);

        //拼合路由数据
        $article_info = array_merge($article_info, $router_list[$article_info['router_id']]);

        return $article_info;
    }
}
