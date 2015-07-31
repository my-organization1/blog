<?php

class TagModel extends BaseModel
{
    /**
     * 获取文章关键词Tag
     * @method getListByArticleId
     * @param  int             $article_id 文章id
     * @return array           关键词数据
     */
    public function getListByArticleId($article_id)
    {
        $map['article_id'] = $article_id;

        $tag_id = D('ArticleTagMap')->_list($map, 'tag_id');

        if (empty($tag_id)) {
            return array();
        }
        $tag_id = array_column($tag_id, 'tag_id');
        $tag_map['id'] = array('in', $tag_id);

        $tag_list = $this->_list($tag_map, 'id,name');

        return $tag_list;
    }

    /**
     * 根据标签名称获取文章id
     * @param  string  $tag_name  标签名称
     * @param  integer $page      页数
     * @param  integer $page_size 分页条数
     * @return array              查询出的数据
     */
    public function getArticleListByTagName($tag_name, $page = 1, $page_size = 10)
    {
        $map['name'] = $tag_name;

        $tag_id = $this->where($map)->getField('id');

        if (empty($tag_id)) {
            return array();
        }

        $where['tag_id'] = $tag_id;

        $field = 'article_id';

        $list = D('ArticleTagMap')->_list($where, $field, '', $page, $page_size);
        $list = array_column($list, 'article_id');
        return $list;
    }
}
