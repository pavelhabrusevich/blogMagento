<?php

declare(strict_types=1);

namespace Habr\Blog\Observer;


use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

/**
 * Class PageSaveAfter
 * @package Habr\Blog\Observer
 */
class PageSaveAfter implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $entity = $observer->getEvent()->getObject();
        $data = $entity->getData();
    }
}