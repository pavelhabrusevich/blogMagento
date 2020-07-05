<?php
declare(strict_types=1);

namespace Habr\Blog\Observer;

use Habr\Blog\Api\Data\PostInterface;
use Habr\Blog\Api\PostManagementInterface;
use Habr\Blog\Model\Post;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

/**
 * Class PageSaveAfter
 * @package Habr\Blog\Observer
 */
class PageSaveAfter implements ObserverInterface
{
    /**
     * @var PostManagementInterface
     */
    private $postManagement;

    /**
     * PageSaveAfter constructor.
     * @param PostManagementInterface $postManagement
     */
    public function __construct(PostManagementInterface $postManagement)
    {
        $this->postManagement = $postManagement;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var PageInterface $entity */
        $entity = $observer->getEvent()->getObject();
        $data = $entity->getData();

        /** @var PostInterface|Post $post */
        $post = $this->postManagement->getEmptyObject();

        $post->setData('author', $data['author']);
        $post->setData('is_post', $data['is_post']);
        $post->setData('publish_date', $data['publish_date']);
        $post->setData('page_id', $data['page_id']);

        $this->postManagement->save($post);
    }
}