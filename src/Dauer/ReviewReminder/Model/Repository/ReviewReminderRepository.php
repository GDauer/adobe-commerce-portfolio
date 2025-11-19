<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Repository;

use Dauer\ReviewReminderApi\Api\Command\GetListReviewReminderCommandInterface;
use Dauer\ReviewReminderApi\Api\Command\GetReviewReminderCommandInterface;
use Dauer\ReviewReminderApi\Api\Command\SaveReviewReminderCommandInterface;
use Dauer\ReviewReminderApi\Api\Command\DeleteReviewReminderCommandInterface;
use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Dauer\ReviewReminderApi\Api\ReviewReminderRepositoryInterface;
use Magento\Framework\Api\Search\SearchCriteriaInterface;

/**
 * Repository implementation
 *
 * @codeCoverageIgnore Don't need to test a class without logic.
 */
class ReviewReminderRepository implements ReviewReminderRepositoryInterface
{
    /**
     * Construct method.
     *
     * @param GetReviewReminderCommandInterface $getReviewReminderCommand
     * @param SaveReviewReminderCommandInterface $saveReviewReminderCommand
     * @param DeleteReviewReminderCommandInterface $deleteReviewReminderCommand
     * @param GetListReviewReminderCommandInterface $getListReviewReminderCommand
     */
    public function __construct(
        private readonly GetReviewReminderCommandInterface $getReviewReminderCommand,
        private readonly SaveReviewReminderCommandInterface $saveReviewReminderCommand,
        private readonly DeleteReviewReminderCommandInterface $deleteReviewReminderCommand,
        private readonly GetListReviewReminderCommandInterface $getListReviewReminderCommand
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getReviewReminder(int $entityId): ReviewReminderInterface
    {
        return $this->getReviewReminderCommand->execute($entityId);
    }

    /**
     * @inheritDoc
     */
    public function saveReviewReminder(ReviewReminderInterface $reviewReminder): ReviewReminderInterface
    {
        return $this->saveReviewReminderCommand->execute($reviewReminder);
    }

    /**
     * @inheritDoc
     */
    public function deleteReviewReminder(int $entityId): void
    {
        $this->deleteReviewReminderCommand->execute($entityId);
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): array
    {
        return $this->getListReviewReminderCommand->execute($searchCriteria);
    }
}
