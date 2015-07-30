<?php

class ArticleModel extends BaseModel
{
    /**
     * 根据分类id获取文章列表
     * @method getListByCatalogId
     * @param  int             $catalog_id 分类id
     * @return array           文章列表数据
     */
    public function getListByCatalogId($catalog_id, $page = 1, $page_size = 10)
    {

        $map['catalog_id'] = $catalog_id;
        $map['status'] = 1;
        $order = 'create_time desc';
        $field = 'id,catalog_id,router_id,title,writer,source,view_count,thumb,create_time';

        $list = $this->_list($map, $field, $order, $page, $page_size);
        $count = $this->_count($map);
        if (empty($list)) {
            return array();
        }
        $router_id = array_column($list, 'router_id');

        $router_list = D('Router')->lists($router_id);

        foreach ($list as $_k => $_v) {
            $list[$_k] = array_merge($_v, $router_list[$_v['router_id']]);
        }
        $list['count'] = $count;

        return $list;
    }
}
