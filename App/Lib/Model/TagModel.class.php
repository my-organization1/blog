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
}
