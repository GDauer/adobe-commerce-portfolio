<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Command;

use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminder\Collection;
use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminder\CollectionFactory;
use Dauer\ReviewReminder\Model\ReviewReminder;
use Dauer\ReviewReminder\Model\ReviewReminderFactory;
use Dauer\ReviewReminderApi\Api\Command\GetListReviewReminderCommandInterface;
use Magento\Framework\Api\Search\SearchCriteriaInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\FilterPool;

/**
 * Get list Review Reminder command implementation.
 */
class GetListReviewReminderCommand implements GetListReviewReminderCommandInterface
{
    /**
     * Construct method.
     *
     * @param CollectionFactory $collectionFactory
     * @param FilterPool $filterPool
     * @param ReviewReminderFactory $reviewReminderFactory
     */
    public function __construct(
        private readonly CollectionFactory $collectionFactory,
        private readonly FilterPool $filterPool,
        private readonly ReviewReminderFactory $reviewReminderFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(SearchCriteriaInterface $searchCriteria): array
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $items = [];
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());

        $this->filterPool->applyFilters($collection, $searchCriteria);

        foreach ($searchCriteria->getSortOrders() as $sortOrder) {
            if ($sortOrder->getField()) {
                $collection->setOrder($sortOrder->getField(), $sortOrder->getDirection());
            }
        }

        foreach ($collection->getItems() as $item) {
            /** @var ReviewReminder $model */
            $model = $this->reviewReminderFactory->create(
                [
                    'data' => $item->getData()
                ]
            );
            $items[] = $model;
        }

        return $items;

    }
}
