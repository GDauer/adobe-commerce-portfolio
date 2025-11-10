<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminderApi\Api\Command;

use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Save command
 */
interface SaveReviewReminderCommandInterface
{
    /**
     * Saves an object and return after.
     *
     * @param ReviewReminderInterface $reviewReminder
     *
     * @throws CouldNotSaveException
     * @return ReviewReminderInterface
     */
    public function execute(ReviewReminderInterface $reviewReminder): ReviewReminderInterface;
}
