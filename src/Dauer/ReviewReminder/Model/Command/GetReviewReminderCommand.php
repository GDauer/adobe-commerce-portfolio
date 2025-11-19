<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Command;

use Dauer\ReviewReminder\Model\ReviewReminderFactory;
use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResourceFactory;
use Dauer\ReviewReminderApi\Api\Command\GetReviewReminderCommandInterface;
use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;

/**
 * Get a review reminder command.
 */
class GetReviewReminderCommand implements GetReviewReminderCommandInterface
{
    /**
     * Construct method.
     *
     * @param ReviewReminderResourceFactory $resourceModelFactory
     * @param ReviewReminderFactory $reviewReminderFactory
     */
    public function __construct(
        private readonly ReviewReminderResourceFactory $resourceModelFactory,
        private readonly ReviewReminderFactory $reviewReminderFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(int $entityId): ReviewReminderInterface
    {
        $emptyModel = $this->reviewReminderFactory->create();
        $resource = $this->resourceModelFactory->create();

        $resource->load($emptyModel, $entityId);
        return $emptyModel;
    }
}
