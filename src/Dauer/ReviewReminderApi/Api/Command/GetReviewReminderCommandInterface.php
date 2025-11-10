<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminderApi\Api\Command;

use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Get command
 */
interface GetReviewReminderCommandInterface
{
    /**
     * Saves an object and return after.
     *
     * @param int $entityId
     *
     * @throws NotFoundException
     * @return ReviewReminderInterface
     */
    public function execute(int $entityId): ReviewReminderInterface;
}
