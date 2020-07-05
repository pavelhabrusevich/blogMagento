<?php

namespace Habr\Blog\Service;

use Habr\Blog\Api\Data\PostInterface;
use Habr\Blog\Api\PostManagementInterface;
use Habr\Blog\Api\PostRepositoryInterface;
use Habr\Blog\Model\Post;
use Habr\Blog\Model\ResourceModel\Post as PostResource;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * Class PostRepository
 * @package Habr\Blog\Service
 */
class PostRepository implements PostRepositoryInterface
{
    private $pageRepository;

    private $searchCriteriaBuilder;

    /**
     * @var PostResource
     */
    private $resource;

    /**
     * @var PostManagementInterface
     */
    private $postManagement;

    /**
     * PostRepository constructor.
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param PostResource $resource
     * @param PostManagementInterface $postManagement
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PostResource $resource,
        PostManagementInterface $postManagement
    ) {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->resource = $resource;
        $this->postManagement = $postManagement;
    }

    public function get()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->pageRepository->getList($searchCriteria);
    }

    /**
     * @param $pageId
     * @return PostInterface|Post
     */
    public function getPageById($pageId): PostInterface
    {
        $post = $this->postManagement->getEmptyObject();
        $this->resource->load($post, $pageId, 'page_id');
        return $post;
    }
}
