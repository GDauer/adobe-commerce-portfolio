<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Test\Unit\Cron;

use Dauer\ReviewReminder\Cron\SendReviewReminderItemsToQueue;
use Dauer\ReviewReminder\Model\Queue\Scheduler;
use Dauer\ReviewReminder\Model\ReviewReminder;
use Dauer\ReviewReminderApi\Api\Command\GetCustomerListForDispatchCommandInterface;
use Dauer\ReviewReminderApi\Api\Command\Queue\GetQueueDataCommandInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Send review reminder items to queue test
 */
class SendReviewReminderItemsToQueueTest extends TestCase
{
    private SendReviewReminderItemsToQueue $subject;
    private Scheduler|MockObject $schedulerMock;
    private GetCustomerListForDispatchCommandInterface|MockObject $getCustomerListForDispatchCommandMock;
    private GetQueueDataCommandInterface|MockObject $getQueueDataCommandMock;
    private int $batchSize = 5;

    protected function setUp(): void
    {
        $this->schedulerMock = $this->createMock(Scheduler::class);
        $this->getCustomerListForDispatchCommandMock = $this->createMock(
            GetCustomerListForDispatchCommandInterface::class
        );
        $this->getQueueDataCommandMock = $this->createMock(GetQueueDataCommandInterface::class);

        $this->subject = new SendReviewReminderItemsToQueue(
            $this->schedulerMock,
            $this->getCustomerListForDispatchCommandMock,
            $this->getQueueDataCommandMock,
            $this->batchSize
        );
    }

    public function testExecuteWithEmptyReviewReminderList(): void
    {
        $this->getCustomerListForDispatchCommandMock->expects(self::once())
            ->method('execute')
            ->willReturn([]);

        $this->schedulerMock->expects(self::never())
            ->method('execute');

        $this->subject->execute();
    }

    public function testExecuteWithEmptyCollectedData(): void
    {
        $reviewReminderMock = $this->createMock(ReviewReminder::class);
        $reviewReminderMock->method('getEntityIdentifier')->willReturn(1);

        $this->getCustomerListForDispatchCommandMock->expects(self::once())
            ->method('execute')
            ->willReturn([$reviewReminderMock]);

        $this->getQueueDataCommandMock->expects(self::once())
            ->method('execute')
            ->with($reviewReminderMock)
            ->willReturn([]);

        $this->schedulerMock->expects(self::never())
            ->method('execute');

        $this->subject->execute();
    }

    public function testExecuteWithPayloadBelowBatchSize(): void
    {
        $reviewReminderMock = $this->createMock(ReviewReminder::class);
        $reviewReminderMock->method('getEntityIdentifier')->willReturn(1);

        $collectedData = [
            [
                'customer_firstname' => 'John',
                'customer_lastname' => 'Doe',
                'customer_email' => 'john@example.com',
                'sku' => 'SKU001',
                'name' => 'Product Name',
                'store_id' => 1
            ],
            [
                'customer_firstname' => 'Jane',
                'customer_lastname' => 'Smith',
                'customer_email' => 'jane@example.com',
                'sku' => 'SKU002',
                'name' => 'Another Product',
                'store_id' => 1
            ]
        ];

        $this->getCustomerListForDispatchCommandMock->expects(self::once())
            ->method('execute')
            ->willReturn([$reviewReminderMock]);

        $this->getQueueDataCommandMock->expects(self::once())
            ->method('execute')
            ->with($reviewReminderMock)
            ->willReturn($collectedData);

        $expectedPayload = [
            [
                'customer_firstname' => 'John',
                'customer_lastname' => 'Doe',
                'customer_email' => 'john@example.com',
                'sku' => 'SKU001',
                'name' => 'Product Name',
                'store_id' => 1
            ],
            [
                'customer_firstname' => 'Jane',
                'customer_lastname' => 'Smith',
                'customer_email' => 'jane@example.com',
                'sku' => 'SKU002',
                'name' => 'Another Product',
                'store_id' => 1
            ]
        ];

        $this->schedulerMock->expects(self::once())
            ->method('execute')
            ->with($expectedPayload, 1);

        $this->subject->execute();
    }

    public function testExecuteWithPayloadReachingBatchSize(): void
    {
        $reviewReminderMock = $this->createMock(ReviewReminder::class);
        $reviewReminderMock->method('getEntityIdentifier')->willReturn(1);

        $collectedData = array_map(fn($i) => [
            'customer_firstname' => 'Customer' . $i,
            'customer_lastname' => 'Lastname' . $i,
            'customer_email' => 'customer' . $i . '@example.com',
            'sku' => 'SKU' . $i,
            'name' => 'Product' . $i,
            'store_id' => 1
        ], range(1, 7));

        $this->getCustomerListForDispatchCommandMock->expects(self::once())
            ->method('execute')
            ->willReturn([$reviewReminderMock]);

        $this->getQueueDataCommandMock->expects(self::once())
            ->method('execute')
            ->with($reviewReminderMock)
            ->willReturn($collectedData);

        $callCount = 0;
        $this->schedulerMock->expects(self::exactly(2))
            ->method('execute')
            ->willReturnCallback(function($payload, $entityId) use (&$callCount) {
                $callCount++;
                if ($callCount === 1) {
                    $this->assertCount(5, $payload);
                    $this->assertEquals(1, $entityId);
                } else {
                    $this->assertCount(2, $payload);
                    $this->assertEquals(1, $entityId);
                }
            });

        $this->subject->execute();
    }

    public function testExecuteWithMultipleReviewReminders(): void
    {
        $reviewReminder1Mock = $this->createMock(ReviewReminder::class);
        $reviewReminder1Mock->method('getEntityIdentifier')->willReturn(1);

        $reviewReminder2Mock = $this->createMock(ReviewReminder::class);
        $reviewReminder2Mock->method('getEntityIdentifier')->willReturn(2);

        $data1 = [
            [
                'customer_firstname' => 'John',
                'customer_lastname' => 'Doe',
                'customer_email' => 'john@example.com',
                'sku' => 'SKU001',
                'name' => 'Product 1',
                'store_id' => 1
            ]
        ];

        $data2 = [
            [
                'customer_firstname' => 'Jane',
                'customer_lastname' => 'Smith',
                'customer_email' => 'jane@example.com',
                'sku' => 'SKU002',
                'name' => 'Product 2',
                'store_id' => 2
            ]
        ];

        $this->getCustomerListForDispatchCommandMock->expects(self::once())
            ->method('execute')
            ->willReturn([$reviewReminder1Mock, $reviewReminder2Mock]);

        $callCount = 0;
        $this->getQueueDataCommandMock->expects(self::exactly(2))
            ->method('execute')
            ->willReturnCallback(function($reviewReminder) use (&$callCount, $reviewReminder1Mock, $reviewReminder2Mock, $data1, $data2) {
                $callCount++;
                if ($callCount === 1) {
                    $this->assertSame($reviewReminder1Mock, $reviewReminder);
                    return $data1;
                } else {
                    $this->assertSame($reviewReminder2Mock, $reviewReminder);
                    return $data2;
                }
            });

        $schedulerCallCount = 0;
        $this->schedulerMock->expects(self::exactly(2))
            ->method('execute')
            ->willReturnCallback(function($payload, $entityId) use (&$schedulerCallCount) {
                $schedulerCallCount++;
                if ($schedulerCallCount === 1) {
                    $this->assertEquals(1, $entityId);
                } else {
                    $this->assertEquals(2, $entityId);
                }
            });

        $this->subject->execute();
    }

    public function testExecuteWithExactBatchSizePayload(): void
    {
        $reviewReminderMock = $this->createMock(ReviewReminder::class);
        $reviewReminderMock->method('getEntityIdentifier')->willReturn(1);

        $collectedData = array_map(fn($i) => [
            'customer_firstname' => 'Customer' . $i,
            'customer_lastname' => 'Lastname' . $i,
            'customer_email' => 'customer' . $i . '@example.com',
            'sku' => 'SKU' . $i,
            'name' => 'Product' . $i,
            'store_id' => 1
        ], range(1, 5));

        $this->getCustomerListForDispatchCommandMock->expects(self::once())
            ->method('execute')
            ->willReturn([$reviewReminderMock]);

        $this->getQueueDataCommandMock->expects(self::once())
            ->method('execute')
            ->with($reviewReminderMock)
            ->willReturn($collectedData);

        $this->schedulerMock->expects(self::once())
            ->method('execute')
            ->willReturnCallback(function($payload, $entityId) {
                $this->assertCount(5, $payload);
                $this->assertEquals(1, $entityId);
            });

        $this->subject->execute();
    }
}
