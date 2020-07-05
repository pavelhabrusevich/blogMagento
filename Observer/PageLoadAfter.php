<?php
declare(strict_types=1);

namespace Habr\Blog\Observer;

use Habr\Blog\Api\PostRepositoryInterface;
use Habr\Blog\Model\Post;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Model\Page;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

/**
 * Class PageSaveAfter
 * @package Habr\Blog\Observer
 */
class PageLoadAfter implements ObserverInterface
{
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * PageLoadAfter constructor.
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var PageInterface|Page $entity */
        $entity = $observer->getEvent()->getObject();

        /** @var Post $post */
        $post = $this->postRepository->getPageById($entity->getId());

        if ($post->getId()){
            $entity->setData('author', $post->getData('author'));
            $entity->setData('is_post', $post->getData('author'));
            $entity->setData('publish_date', $post->getData('publish_date'));
        }
    }
}