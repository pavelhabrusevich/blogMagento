<?php
declare(strict_types=1);

namespace Habr\Blog\ViewModel;

use Habr\Blog\Service\PostRepository;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Cms\Block\Page;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Blog
 * @package Habr\Blog\ViewModel
 */
class Blog implements ArgumentInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * Blog constructor.
     * @param SerializerInterface $serializer
     * @param PostRepository $postRepository
     * @param UrlInterface $url
     */
    public function __construct(
        SerializerInterface $serializer,
        PostRepository $postRepository,
        UrlInterface $url
    ) {
        $this->serializer = $serializer;
        $this->postRepository = $postRepository;
        $this->url = $url;
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getPostsJson(): string
    {
        $postsSearchResults = $this->postRepository->get();

        return $this->serializer->serialize($this->getPosts($postsSearchResults));
    }

    /**
     * @param PageSearchResultsInterface $postsSearchResults
     * @return array
     */
    private function getPosts(PageSearchResultsInterface $postsSearchResults)
    {
        $result = [];

        /** @var PageInterface|Page $post */
        foreach ($postsSearchResults->getItems() as $post) {
            $result[] = [
                "id" => $post->getId(),
                "title" => $post->getTitle(),
                "url" => $this->url->getUrl($post->getIdentifier()),
                "published_date" => $post->getData('publish_date'),
                "content" => mb_substr(strip_tags($post->getContent()), 0, 255),
                "author" => $post->getData('author')
            ];
        }

        return $result;
    }
}
