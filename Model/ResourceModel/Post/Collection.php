<?php

namespace Habr\Blog\Model\ResourceModel\Post;

use Habr\Blog\Model\Post;
use \Habr\Blog\Model\ResourceModel\Post as PostResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Post::class, PostResource::class);
    }
}