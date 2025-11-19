<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Queue\Handler;

use Dauer\ReviewReminderApi\Api\Command\Mail\SentReviewReminderMailInterface;
use Dauer\ReviewReminderApi\Api\ReviewReminderRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Consumer for queue.
 */
class Handler
{
    /**
     * Construct method.
     *
     * @param SerializerInterface $serializer
     * @param SentReviewReminderMailInterface $sentReviewReminderMail
     * @param ReviewReminderRepositoryInterface $reviewReminderRepository
     */
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly SentReviewReminderMailInterface $sentReviewReminderMail,
        private readonly ReviewReminderRepositoryInterface $reviewReminderRepository
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

        $review = $this->reviewReminderRepository->getReviewReminder((int) $topicData['review_id']);

        $review->setEmailUsed(true);
        $this->reviewReminderRepository->saveReviewReminder($review);
    }
}
