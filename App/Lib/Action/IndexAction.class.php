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
        $article_list = D('Article')->lists();
        $this->display(C('APP_DEFAULT_THEME').'/index');
    }
}
