<?php

class CatalogModel extends BaseModel
{
    protected $tableName = 'catalog';

    /**
     * 根据id获取分类详情
     * @param  int $catalog_id 分类主键id
     * @return array           分类的信息
     */
    public function info($catalog_id)
    {
        $map['id'] = $catalog_id;
        $field = 'id,pid,router_id,name,sort,title,keywords,description,is_show,list_tpl,content_tpl';

        $info = $this->_get($map, $field);

        //获取路由信息
        $router_list = D('Router')->lists($info['router_id']);

        //拼合数据
        $info = array_merge($info, $router_list[$info['router_id']]);
        if (empty($info)) {
            return array();
        }

        return $info;
    }

    /**
     * 获取导航
     * @method menu
     * @return array 导航数据
     */
    public function menu()
    {
        $map['is_show'] = 1;
        $field = 'id,pid,router_id,name,sort,title,keywords,description,is_show,list_tpl,content_tpl';
        $list = $this->_list($map, $field, 'sort desc');

        $router_id = array_column($list, 'router_id');
        //获取路由数据
        $router_list = D('Router')->lists($router_id);
        //合并数据
        foreach ($list as $_k => $_v) {
            $list[$_k] = array_merge($_v, $router_list[$_v['router_id']]);
        }

        return $list;
    }
}
