<?php
declare(strict_types=1);

namespace Habr\Blog\Observer;

use Habr\Blog\Api\PostRepositoryInterface;
use Habr\Blog\Model\Post;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Model\Page;
use Magento\Cms\Model\ResourceModel\Page\Collection;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Habr\Blog\Model\ResourceModel\Post\Collection as PostCollection;
use Habr\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;

/**
 * Class PageCollectionLoadAfter
 * @package Habr\Blog\Observer
 */
class PageCollectionLoadAfter implements ObserverInterface
{
    /**
     * @var PostCollectionFactory
     */
    private $postCollectionFactory;

    /**
     * PageCollectionLoadAfter constructor.
     * @param PostCollectionFactory $postCollectionFactory
     */
    public function __construct(PostCollectionFactory $postCollectionFactory)
    {
        $this->postCollectionFactory = $postCollectionFactory;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var Collection $entity */
        $collection = $observer->getEvent()->getPageCollection();

        $pageIds = [];

        /** @var Page $item */
        foreach ($collection->getItems() as $item){
            $pageIds[] = $item->getId();
        }

        $postCollection = $this->postCollectionFactory->create();
        $postCollection->addFieldToFilter('page_id', ['in' => $pageIds]);

        foreach ($postCollection->getItems() as $post){
            $page = $collection->getItemById($post->getPageId());
            if ($page->getId()){
                $page->setData('author', $post->getData('author'));
                $page->setData('is_post', $post->getData('author'));
                $page->setData('publish_date', $post->getData('publish_date'));
            }
        }



//        /** @var Post $post */
//        $post = $this->postRepository->getPageById($entity->getId());
//
//        if ($post->getId()){
//            $entity->setData('author', $post->getData('author'));
//            $entity->setData('is_post', $post->getData('author'));
//            $entity->setData('publish_date', $post->getData('publish_date'));
//        }
    }
}