<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Command;

use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResource;
use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResourceFactory;
use Dauer\ReviewReminderApi\Api\Command\SaveReviewReminderCommandInterface;
use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Exception;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Save command implementation.
 */
class SaveReviewReminderCommand implements SaveReviewReminderCommandInterface
{
    /**
     * Construct method.
     *
     * @param ReviewReminderResourceFactory $resourceModelFactory
     */
    public function __construct(
        private readonly ReviewReminderResourceFactory $resourceModelFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(ReviewReminderInterface $reviewReminder): ReviewReminderInterface
    {
        try {
            $resource = $this->resourceModelFactory->create();
            $resource->save($reviewReminder);

            return $reviewReminder;
        } catch (Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
    }
}
