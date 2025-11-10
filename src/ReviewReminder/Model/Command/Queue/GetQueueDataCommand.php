<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Command\Queue;

use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResourceFactory;
use Dauer\ReviewReminderApi\Api\Command\Queue\GetQueueDataCommandInterface;
use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;

/**
 * Command implementation
 */
class GetQueueDataCommand implements GetQueueDataCommandInterface
{
    /**
     * Construct method.
     *
     * @param ReviewReminderResourceFactory $resourceModelFactory
     */
    public function __construct(
        private readonly ReviewReminderResourceFactory $resourceModelFactory,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(ReviewReminderInterface $reviewReminder): array
    {
        $resource = $this->resourceModelFactory->create();

        return $resource->getReviewReminderCollectedData($reviewReminder);
    }
}
