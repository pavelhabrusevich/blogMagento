<?php

namespace Habr\Blog\Service;

use Habr\Blog\Api\Data\PostInterface;
use Habr\Blog\Api\PostManagementInterface;
use Habr\Blog\Model\PostFactory;
use Habr\Blog\Model\ResourceModel\Post as PostResource;
use Magento\Framework\Exception\AlreadyExistsException;

/**
 * Class PostManagement
 * @package Habr\Blog\Service
 */
class PostManagement implements PostManagementInterface
{
    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @var PostResource
     */
    private $resource;

    /**
     * PostManagement constructor.
     * @param PostFactory $postFactory
     * @param PostResource $resource
     */
    public function __construct(
        PostFactory $postFactory,
        PostResource $resource
    ) {
        $this->postFactory = $postFactory;
        $this->resource = $resource;
    }

    /**
     * @return PostInterface
     */
    public function getEmptyObject(): PostInterface
    {
        return $this->postFactory->create();
    }

    /**
     * @param PostInterface $post
     * @throws AlreadyExistsException
     */
    public function save(PostInterface $post)
    {
        $this->resource->save($post);
    }
}