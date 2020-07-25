<?php
declare(strict_types=1);

namespace Habr\Blog\Observer;

use Habr\Blog\Api\Data\PostInterface;
use Habr\Blog\Api\PostManagementInterface;
use Habr\Blog\Api\PostRepositoryInterface;
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
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * PageSaveAfter constructor.
     * @param PostManagementInterface $postManagement
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(
        PostManagementInterface $postManagement,
        PostRepositoryInterface $postRepository)
    {
        $this->postManagement = $postManagement;
        $this->postRepository = $postRepository;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var PageInterface $entity */
        $entity = $observer->getEvent()->getObject();
        $data = $entity->getData();

        $post = $this->postRepository->getPageById($entity->getId());
        if (!$post->getId()){
            $post->setData('page_id', $data['page_id']);
        }

        $post->setData('author', $data['author']);
        $post->setData('is_post', $data['is_post']);
        $post->setData('publish_date', $data['publish_date']);

        $this->postManagement->save($post);
    }
}