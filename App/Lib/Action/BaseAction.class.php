<?php
class BaseAction extends Action{

    function _initialize()
    {
        $this->getRouter();
    }

    private function getRouter()
    {
        // $list = D('Router')->select();
        // $list = array_column($list, 'link', 'rule');
        $list['/article/'] = 'Catalog/index?id=4';
        C('URL_ROUTE_RULES', $list);
        tag('route_check');
    }
}
