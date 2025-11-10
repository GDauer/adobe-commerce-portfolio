<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Queue\Handler;

use Dauer\ReviewReminderApi\Api\Command\Mail\SentReviewReminderMailInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Consumer for queue.
 */
readonly class Handler
{
    /**
     * Construct method.
     *
     * @param SerializerInterface $serializer
     * @param SentReviewReminderMailInterface $sentReviewReminderMail
     */
    public function __construct(
        private SerializerInterface $serializer,
        private SentReviewReminderMailInterface $sentReviewReminderMail
    ) {

    }

    /**
     * Execute method.
     *
     * @param string $data
     *
     * @return void
     * @throws LocalizedException
     */
    public function execute(string $data): void
    {
        $topicData = $this->serializer->unserialize($data)['data'];

        foreach ($topicData['customer_data'] as $customerData) {
            $customerData['customer_name'] = $customerData['customer_firstname'] . ' ' . $customerData['customer_lastname'];
            $this->sentReviewReminderMail->execute($customerData);
        }
    }
}
