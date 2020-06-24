<?php

namespace Habr\Blog\Service;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class PostRepository
{
    private $pageRepository;
    private $searchCriteriaBuilder;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function get()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->pageRepository->getList($searchCriteria);
    }
}
