<?php
/**
 * 首页
 * @package Action
 * @author guolei <2387813033@qq.com>
 * @copyright 2015 blog
 */
class IndexAction extends BaseAction
{
    public function index()
    {
        //推荐文章列表
        $article_list = D('Article')->listsByCatalogId('', 'view_count desc', 1, 10);

        //最新文章
        $new_article_list = D('Article')->lists('', '', 1, 8);

        $this->assign('article_list', $article_list);

        $this->assign('new_artilce_list', $new_article_list);
        $this->display(C('APP_DEFAULT_THEME') . '/index');
    }
}
