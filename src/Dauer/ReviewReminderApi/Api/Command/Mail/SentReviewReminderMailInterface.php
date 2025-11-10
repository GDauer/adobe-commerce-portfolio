<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminderApi\Api\Command\Mail;

use Magento\Framework\Exception\LocalizedException;

/**
 * Sent review reminder command
 */
interface SentReviewReminderMailInterface
{
    /**
     * Execute method.
     *
     * @param array $templateVars
     *
     * @throws LocalizedException
     * @return void
     */
    public function execute(array $templateVars): void;
}
