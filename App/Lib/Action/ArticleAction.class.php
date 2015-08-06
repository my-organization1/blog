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

        $this->addViewCount($article_id); //文章浏览数+1

        $article_info = D('Article')->get($article_id); //获取文章信息

        $catalog_info = D('Catalog')->get($article_info['catalog_id']); //获取分类详情

        $tag_list = D('Tag')->getListByArticleId($article_id); //获取文章关键词

        $prev_article_info = $this->getPrevArticle($article_id); //获取上一篇文章
        $next_article_info = $this->getNextArticle($article_id); //获取下一篇文章

        $click_article_list = D('Article')->listsByCatalogId($id, 'view_count desc', 1, 9); //获取点击排行文章

        $relevant_artilce_list = $this->getRelevantArticleList($tag_list);

        $this->assign('article_info', $article_info);
        $this->assign('prev_article_info', $prev_article_info);
        $this->assign('next_article_info', $next_article_info);
        $this->assign('catalog_info', $catalog_info);
        $this->assign('tag_list', $tag_list);
        $this->assign('click_article_list', $click_article_list);
        $this->assign('relevant_artilce_list', $relevant_artilce_list);

        $this->display(C('APP_DEFAULT_THEME') . '/' . $catalog_info['content_tpl']);
    }

    /**
     * 文章浏览数+1
     * @param int $id 文章id
     */
    private function addViewCount($id)
    {
        $map['id'] = $id;

        $data['view_count'] = array('exp', 'view_count+1');

        $result = D('Article')->where($map)->save($data);

        return $result;
    }
    /**
     * 获取上一篇文章
     * @param  int $id 当前文章id
     * @return array     查询到的数据
     */
    private function getPrevArticle($id)
    {
        $map['id'] = array('lt', $id);
        $order = 'id desc';
        $prev_article_info = D('Article')->get($map, $order);

        $prev_article_info = empty($prev_article_info) ? array() : $prev_article_info;
        return $prev_article_info;
    }
    /**
     * 获取下一篇文章
     * @param  int $id 当前文章id
     * @return array   查询到的数据
     */
    private function getNextArticle($id)
    {
        $map['id'] = array('gt', $id);
        $next_article_info = D('Article')->get($map);

        $next_article_info = empty($next_article_info) ? array() : $next_article_info;
        return $next_article_info;
    }

    /**
     * 获取相关文章
     * @param  array $tag_list 标签列表
     * @return array           查询出的数据
     */
    private function getRelevantArticleList($tag_list)
    {
        $tag_id = array_column($tag_list, 'id');
        $map['tag_id'] = $tag_id;
        $article_list = D('ArticleTagMap')->_list($map, 'article_id', 'id desc', 1, 5);

        if ($article_list) {
            return array();
        }

        $article_id = array_column($article_list, 'article_id');

        $where['id'] = array('in', $article_id);

        $article_list = D('Article')->lists($where);

        return $article_list;
    }
}
