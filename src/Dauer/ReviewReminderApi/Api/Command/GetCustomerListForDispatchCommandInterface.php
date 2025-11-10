<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminderApi\Api\Command;

use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;

/**
 * Retrieve the list of customer to send the e-mail
 */
interface GetCustomerListForDispatchCommandInterface
{
    /**
     * Execute method.
     *
     * @return ReviewReminderInterface[]
     */
    public function execute(): array;
}
