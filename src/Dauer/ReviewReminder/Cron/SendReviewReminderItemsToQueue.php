<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Cron;

use Dauer\ReviewReminder\Model\Queue\Scheduler;
use Dauer\ReviewReminderApi\Api\Command\GetCustomerListForDispatchCommandInterface;
use Dauer\ReviewReminderApi\Api\Command\Queue\GetQueueDataCommandInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Cron Job to schedule to queue.
 */
class SendReviewReminderItemsToQueue
{
    /**
     * Construct method.
     *
     * @param Scheduler $scheduler
     * @param GetCustomerListForDispatchCommandInterface $getCustomerListForDispatchCommand
     * @param GetQueueDataCommandInterface $getQueueDataCommand
     * @param int $batchSize
     */
    public function __construct(
        private readonly Scheduler $scheduler,
        private readonly GetCustomerListForDispatchCommandInterface $getCustomerListForDispatchCommand,
        private readonly GetQueueDataCommandInterface $getQueueDataCommand,
        private readonly int $batchSize
    ) {

    }

    /**
     * Cronjob execute method
     *
     * @return void
     * @throws LocalizedException
     */
    public function execute(): void
    {
        $reviewReminderList = $this->getCustomerListForDispatchCommand->execute();

        foreach ($reviewReminderList as $reviewReminder) {
            $collectedData = $this->getQueueDataCommand->execute($reviewReminder);

            $payload = [];
            foreach ($collectedData as $data) {
                $payload[] = [
                    'customer_firstname' => $data['customer_firstname'],
                    'customer_lastname' => $data['customer_lastname'],
                    'customer_email' => $data['customer_email'],
                    'sku' => $data['sku'],
                    'name' => $data['name'],
                    'store_id' => $data['store_id']
                ];

                if (count($payload) >= $this->batchSize) {
                    $this->scheduler->execute($payload, $reviewReminder->getEntityIdentifier());
                    $payload = [];
                }
            }

            if (!empty($payload)) {
                $this->scheduler->execute($payload, $reviewReminder->getEntityIdentifier());
            }
        }
    }
}
