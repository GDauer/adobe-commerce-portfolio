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
readonly class SendReviewReminderItemsToQueue
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
        private Scheduler $scheduler,
        private GetCustomerListForDispatchCommandInterface $getCustomerListForDispatchCommand,
        private GetQueueDataCommandInterface $getQueueDataCommand,
        private int $batchSize
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
                ];

                if (count($payload) >= $this->batchSize) {
                    $this->scheduler->execute($payload);
                    $payload = [];
                }
            }

            if (!empty($payload)) {
                var_dump($payload);
                $this->scheduler->execute($payload);
            }

            //Trocar flag de email
        }
    }
}
