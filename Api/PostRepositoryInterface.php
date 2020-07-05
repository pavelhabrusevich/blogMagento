<?php

namespace Habr\Blog\Api;

use Habr\Blog\Api\Data\PostInterface;

/**
 * Interface PostRepositoryInterface
 * @api
 */
interface PostRepositoryInterface
{
    /**
     * @return PostInterface
     */
    public function get();

    /**
     * @param $pageId
     * @return PostInterface
     */
    public function getPageById($pageId) : PostInterface;
}