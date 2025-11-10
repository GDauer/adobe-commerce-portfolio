<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Queue;

use Magento\Framework\DataObject\IdentityGeneratorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\MessageQueue\Publisher;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Queue scheduler
 */
class Scheduler
{
    private const TOPIC_NAME = 'dauer.review.reminder';

    /**
     * @param Publisher $publisher
     * @param IdentityGeneratorInterface $identityGenerator
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private Publisher $publisher,
        private IdentityGeneratorInterface $identityGenerator,
        private SerializerInterface $serializer
    ) {
    }

    /**
     * Schedule reminder job.
     *
     * @param array $customerData ['email', 'name', 'product']
     *
     * @return void
     */
    public function execute(array $customerData): void
    {
        $bulkUuid = $this->identityGenerator->generateId();
        $data = [
            'data' => [
                'bulk_uuid' => $bulkUuid,
                'topic_name' => self::TOPIC_NAME,
                'customer_data' => $customerData
            ]
        ];

        $this->publisher->publish(self::TOPIC_NAME, $this->serializer->serialize($data));
    }
}
