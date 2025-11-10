<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminderApi\Api\Command;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Delete command
 */
interface DeleteReviewReminderCommandInterface
{
    /**
     * Saves an object and return after.
     *
     * @param int $entityId
     *
     * @throws CouldNotDeleteException
     * @return void
     */
    public function execute(int $entityId): void;
}
