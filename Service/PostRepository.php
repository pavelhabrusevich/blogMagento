<?php

namespace Habr\Blog\Service;

use Habr\Blog\Api\Data\PostInterface;
use Habr\Blog\Api\PostManagementInterface;
use Habr\Blog\Api\PostRepositoryInterface;
use Habr\Blog\Model\Post;
use Habr\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Habr\Blog\Model\ResourceModel\Post as PostResource;
use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;

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
     * @var PostCollectionFactory
     */
    protected $postCollectionFactory;

    /**
     * PostRepository constructor.
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param PostResource $resource
     * @param PostManagementInterface $postManagement
     * @param PostCollectionFactory $postCollectionFactory
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        PostResource $resource,
        PostManagementInterface $postManagement,
        PostCollectionFactory $postCollectionFactory
    ) {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->resource = $resource;
        $this->postManagement = $postManagement;
        $this->postCollectionFactory = $postCollectionFactory;
    }

    /**
     * @return PageSearchResultsInterface
     * @throws LocalizedException
     */
    public function get()
    {
        $postCollection = $this->postCollectionFactory->create();
        $postCollection->addFieldToFilter('is_post', ['eq' => 1]);

        $pageIds = [];

        /** @var Post $post */
        foreach ($postCollection->getItems() as $post){
            $pageIds[] = $post->getData('page_id');
        }

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('page_id', $pageIds, 'in')
            ->create();

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
