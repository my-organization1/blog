<?php
/**
 * 文章详情Action
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class ArticleAction extends BaseAction
{
    public function index()
    {
        $article_id = I('id');

        $map['id'] = $article_id;
        $field = 'id,catalog_id,router_id,title,content,writer,source,view_count,thumb,create_time';

        $article_info = D('Article')->_get($map, $field);

        //获取栏目信息
        $catalog_map['id'] = $article_info['catalog_id'];
        $catalog_field = 'id,pid,router_id,name,sort,title,keywords,description,is_show,list_tpl,content_tpl';
        $catalog_info = D('Catalog')->_get($catalog_map, $catalog_field);

        //获取关键词
        $tag_list = D('Tag')->getListByArticleId($article_id);

        //查询路由信息
        $router_id[] = $article_info['router_id'];
        $router_id[] = $catalog_info['router_id'];

        $router_list = D('Router')->lists($router_id);
        //拼合路由数据
        $article_info = array_merge($article_info, $router_list[$article_info['router_id']]);
        $catalog_info = array_merge($catalog_info, $router_list[$catalog_info['router_id']]);

        $this->assign('article_info', $article_info);
        $this->assign('catalog_info', $catalog_info);
        $this->assign('tag_list', $tag_list);

        $this->display(C('APP_DEFAULT_THEME').'/'.$catalog_info['content_tpl']);
    }
}
