<?php

namespace Habr\Blog\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 * @package Habr\Blog\Controller\Blog
 */
class Index extends Action
{
    public function execute()
    {
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $page;
    }
}
