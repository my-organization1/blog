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
        if (empty($info)) {
            return array();
        }

        return $info;
    }
}