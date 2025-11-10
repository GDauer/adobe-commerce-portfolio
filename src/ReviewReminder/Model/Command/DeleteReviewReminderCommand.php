<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Command;

use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResource;
use Dauer\ReviewReminderApi\Api\Command\DeleteReviewReminderCommandInterface;
use Dauer\ReviewReminderApi\Api\Command\GetReviewReminderCommandInterface;
use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Implements delete command
 */
class DeleteReviewReminderCommand implements DeleteReviewReminderCommandInterface
{
    /**
     * Construct method.
     *
     * @param ReviewReminderResource $resourceModel
     * @param GetReviewReminderCommandInterface $commandGet
     */
    public function __construct(
        private readonly ReviewReminderResource $resourceModel,
        private readonly GetReviewReminderCommandInterface $commandGet
    ){
    }

    /**
     * @inheritDoc
     */
    public function execute(int $entityId): void
    {
        try {
            $this->resourceModel->delete(
                $this->commandGet->execute($entityId)
            );
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
    }
}
