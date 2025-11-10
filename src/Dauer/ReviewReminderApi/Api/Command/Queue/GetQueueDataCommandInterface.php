<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminderApi\Api\Command\Queue;

use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;

/**
 * Command to retrieve queue data to serialize.
 */
interface GetQueueDataCommandInterface
{
    /**
     * Execute method.
     *
     * @param ReviewReminderInterface $reviewReminder
     *
     * @return array
     */
    public function execute(ReviewReminderInterface $reviewReminder): array;
}
