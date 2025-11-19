<?php
/**
 * Unit test for Scheduler
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Test\Unit\Model\Queue;

use Dauer\ReviewReminder\Model\Queue\Scheduler;
use Magento\Framework\DataObject\IdentityGeneratorInterface;
use Magento\Framework\MessageQueue\Publisher;
use Magento\Framework\Serialize\SerializerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SchedulerTest extends TestCase
{
    private Scheduler $scheduler;
    private Publisher|MockObject $publisherMock;
    private IdentityGeneratorInterface|MockObject $identityGeneratorMock;
    private SerializerInterface|MockObject $serializerMock;

    protected function setUp(): void
    {
        $this->publisherMock = $this->createMock(Publisher::class);
        $this->identityGeneratorMock = $this->createMock(IdentityGeneratorInterface::class);
        $this->serializerMock = $this->createMock(SerializerInterface::class);

        $this->scheduler = new Scheduler(
            $this->publisherMock,
            $this->identityGeneratorMock,
            $this->serializerMock
        );
    }

    /**
     * Test that execute generates bulk UUID and publishes to queue
     */
    public function testExecutePublishesMessageToQueue(): void
    {
        $bulkUuid = 'test-bulk-uuid-12345';
        $reviewId = 42;
        $customerData = [
            'email' => 'test@example.com',
            'name' => 'John Doe',
            'product' => 'Test Product'
        ];
        $serializedData = json_encode(['bulk_uuid' => $bulkUuid]);

        $this->identityGeneratorMock->expects(self::once())
            ->method('generateId')
            ->willReturn($bulkUuid);

        $this->serializerMock->expects(self::once())
            ->method('serialize')
            ->willReturn($serializedData);

        $this->publisherMock->expects(self::once())
            ->method('publish')
            ->with('dauer.review.reminder', $serializedData);

        $this->scheduler->execute($customerData, $reviewId);
    }
}
