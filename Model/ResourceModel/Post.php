<?php

namespace Habr\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Post
 */
class Post extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('habr_blog_page_post', 'post_id');
    }
}