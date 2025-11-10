<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminderApi\Api;

use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Magento\Framework\Api\Search\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NotFoundException;

/**
 * Repository for Review Reminder.
 */
interface ReviewReminderRepositoryInterface
{
    /**
     * Get Review reminder entity.
     *
     * @param int $entityId
     *
     * @throws NotFoundException
     * @return ReviewReminderInterface
     */
    public function getReviewReminder(int $entityId): ReviewReminderInterface;

    /**
     * Saves Review reminder entity.
     *
     * @param ReviewReminderInterface $reviewReminder
     *
     * @throws CouldNotSaveException
     * @return ReviewReminderInterface
     */
    public function saveReviewReminder(ReviewReminderInterface $reviewReminder): ReviewReminderInterface;

    /**
     * Delete review reminder.
     *
     * @param int $entityId
     *
     * @throws CouldNotDeleteException
     * @return void
     */
    public function deleteReviewReminder(int $entityId): void;

    /**
     * Get List based on search criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return ReviewReminderInterface[]
     */
    public function getList(SearchCriteriaInterface $searchCriteria): array;
}
