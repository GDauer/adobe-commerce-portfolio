<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Queue;

use Magento\Framework\DataObject\IdentityGeneratorInterface;
use Magento\Framework\MessageQueue\Publisher;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Queue scheduler
 */
class Scheduler
{
    private const string TOPIC_NAME = 'dauer.review.reminder';

    /**
     * @param Publisher $publisher
     * @param IdentityGeneratorInterface $identityGenerator
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private readonly Publisher $publisher,
        private readonly IdentityGeneratorInterface $identityGenerator,
        private readonly SerializerInterface $serializer
    ) {
    }

    /**
     * Schedule reminder job.
     *
     * @param array $customerData ['email', 'name', 'product']
     * @param int $reviewId
     *
     * @return void
     */
    public function execute(array $customerData, int $reviewId): void
    {
        $bulkUuid = $this->identityGenerator->generateId();
        $data = [
            'data' => [
                'bulk_uuid' => $bulkUuid,
                'topic_name' => self::TOPIC_NAME,
                'review_id' => $reviewId,
                'customer_data' => $customerData
            ]
        ];

        $this->publisher->publish(self::TOPIC_NAME, $this->serializer->serialize($data));
    }
}
