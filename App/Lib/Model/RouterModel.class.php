<?php

class RouterModel extends BaseModel
{
    /**
     * 根据路由id查询路由表信息
     * @method lists
     * @param  string|int $router_id 路由表id,支持int或者逗号分隔字符串
     * @return array            查询出得数据
     */
    public function lists($router_id)
    {
        //查询路由表
        $router_map['id'] = array('in', $router_id);
        $router_field = 'id as router_id,rule,link';

        $router_list = D('Router')->_list($router_map, $router_field);
        foreach ($router_list as $_k => $_v) {
            $router_list[$_k]['url'] = RestoreRule($_v['rule']);
        }
        $router_list = array_column($router_list, null, 'router_id');

        return $router_list;
    }
}
