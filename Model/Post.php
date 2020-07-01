<?php

namespace Habr\Blog\Model;

use Habr\Blog\Api\Data\PostInterface;
use Magento\Framework\Model\AbstractModel;
use Habr\Blog\Model\ResourceModel\Post as PostResource;

/**
 * Class Post
 * @package Habr\Blog\Model
 */
class Post extends AbstractModel implements PostInterface
{
    protected function _construct()
    {
        $this->_init(PostResource::class);
    }
}