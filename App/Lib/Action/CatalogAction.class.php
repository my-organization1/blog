<?php
/**
 * 分类Action
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */

class CatalogAction extends BaseAction
{
    public function index()
    {
        $id = I('get.id');
        $page = intval(I('page', 1));
        $page_size = intval(I('page_size', 10));
        //获取栏目信息
        $info = D('Catalog')->info($id);
        //获取文章信息
        $article_list = D('Article')->getListByCatalogId($id, $page, $page_size);

        $count = $article_list['count'];
        unset($article_list['count']);
        //分页处理
        $PageHelper = new PageHelper($count, $page, $page_size);
        $page_list = $PageHelper->show();

        $get_params = I('get.');
        $get_params['page'] = $page;
        unset($get_params['id']);

        foreach ($page_list as $_k => $_v) {
            $page_list[$_k]['url'] = U($_SERVER['PATH_INFO'], '', false).'?'.http_build_query($get_params).'.'.C('URL_HTML_SUFFIX');
        }
        //赋值
        $this->assign('catalog_info', $info);
        $this->assign('article_list', $article_list);
        $this->assign('count', $count);
        $this->assign('page_list', $page_list);

        $this->display(C('APP_DEFAULT_THEME').'/'.$info['list_tpl']);
    }
}
