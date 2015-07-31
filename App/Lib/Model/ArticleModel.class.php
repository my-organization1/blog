<?php

class ArticleModel extends BaseModel
{
    /**
     * 获取文章列表
     * @param  int  $catalog_id 分类id
     * @param  string  $order      排序规则
     * @param  integer $page       分页数
     * @param  integer $page_size  每页条数
     * @return array               查询出来的数据
     */
    public function lists($catalog_id = '', $order = '', $page = 1, $page_size = 10)
    {
        if (empty($catalog_id)) {
            $map['catalog_id'] = $catalog_id;
        }
        $order = empty($order) ? 'create_time desc' : $order . ' desc';
        $field = 'id,catalog_id,router_id,title,writer,source,view_count,thumb,create_time';

        $list = $this->_list($map, $field, $order, $page, $page_size);

        if (empty($list)) {
            return array();
        }
        //文章访问路由
        $router_id = array_column($list, 'router_id');

        $router_list = D('Router')->lists($router_id);

        foreach ($list as $_k => $_v) {
            $list[$_k] = array_merge($_v, $router_list[$_v['router_id']]);
        }
        $list['count'] = $count;

        return $list;
    }
}
