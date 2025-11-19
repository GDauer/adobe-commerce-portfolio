<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Test\Unit\Model\Command\Queue;

use Dauer\ReviewReminder\Model\Command\Queue\GetQueueDataCommand;
use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResource;
use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResourceFactory;
use Dauer\ReviewReminder\Model\ReviewReminder;
use PHPUnit\Framework\TestCase;

class GetQueueDataCommandTest extends TestCase
{
    private GetQueueDataCommand $subject;
    private ReviewReminderResourceFactory $resourceModelFactoryMock;
    private ReviewReminderResource $resourceModelMock;

    protected function setUp(): void
    {
        $this->resourceModelFactoryMock = $this->createMock(ReviewReminderResourceFactory::class);
        $this->resourceModelMock = $this->createMock(ReviewReminderResource::class);

        $this->resourceModelFactoryMock->expects(self::any())
            ->method('create')
            ->willReturn($this->resourceModelMock);

        $this->subject = new GetQueueDataCommand($this->resourceModelFactoryMock);
    }

    public function testExecuteReturnsEmptyArray(): void
    {
        $reviewReminderMock = $this->createMock(ReviewReminder::class);

        $this->resourceModelMock->expects(self::once())
            ->method('getReviewReminderCollectedData')
            ->with($reviewReminderMock)
            ->willReturn([]);

        $result = $this->subject->execute($reviewReminderMock);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testExecuteReturnsSingleItem(): void
    {
        $reviewReminderMock = $this->createMock(ReviewReminder::class);

        $expectedData = [
            [
                'customer_firstname' => 'John',
                'customer_lastname' => 'Doe',
                'customer_email' => 'john@example.com',
                'sku' => 'SKU001',
                'name' => 'Product Name',
                'store_id' => 1
            ]
        ];

        $this->resourceModelMock->expects(self::once())
            ->method('getReviewReminderCollectedData')
            ->with($reviewReminderMock)
            ->willReturn($expectedData);

        $result = $this->subject->execute($reviewReminderMock);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals($expectedData, $result);
    }

    public function testExecuteReturnsMultipleItems(): void
    {
        $reviewReminderMock = $this->createMock(ReviewReminder::class);

        $expectedData = [
            [
                'customer_firstname' => 'John',
                'customer_lastname' => 'Doe',
                'customer_email' => 'john@example.com',
                'sku' => 'SKU001',
                'name' => 'Product 1',
                'store_id' => 1
            ],
            [
                'customer_firstname' => 'Jane',
                'customer_lastname' => 'Smith',
                'customer_email' => 'jane@example.com',
                'sku' => 'SKU002',
                'name' => 'Product 2',
                'store_id' => 1
            ],
            [
                'customer_firstname' => 'Bob',
                'customer_lastname' => 'Johnson',
                'customer_email' => 'bob@example.com',
                'sku' => 'SKU003',
                'name' => 'Product 3',
                'store_id' => 2
            ]
        ];

        $this->resourceModelMock->expects(self::once())
            ->method('getReviewReminderCollectedData')
            ->with($reviewReminderMock)
            ->willReturn($expectedData);

        $result = $this->subject->execute($reviewReminderMock);

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertEquals($expectedData, $result);
    }

    public function testExecuteWithDifferentReviewReminders(): void
    {
        $reviewReminder1Mock = $this->createMock(ReviewReminder::class);
        $reviewReminder2Mock = $this->createMock(ReviewReminder::class);

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

        $callCount = 0;
        $this->resourceModelMock->expects(self::exactly(2))
            ->method('getReviewReminderCollectedData')
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

        $result1 = $this->subject->execute($reviewReminder1Mock);
        $result2 = $this->subject->execute($reviewReminder2Mock);

        $this->assertEquals($data1, $result1);
        $this->assertEquals($data2, $result2);
    }

    public function testExecuteCallsResourceModelFactory(): void
    {
        $reviewReminderMock = $this->createMock(ReviewReminder::class);

        $this->resourceModelFactoryMock->expects(self::once())
            ->method('create')
            ->willReturn($this->resourceModelMock);

        $this->resourceModelMock->expects(self::once())
            ->method('getReviewReminderCollectedData')
            ->with($reviewReminderMock)
            ->willReturn([]);

        $this->subject->execute($reviewReminderMock);
    }

    public function testExecuteReturnsArrayWithSpecificStructure(): void
    {
        $reviewReminderMock = $this->createMock(ReviewReminder::class);

        $expectedData = [
            [
                'customer_firstname' => 'John',
                'customer_lastname' => 'Doe',
                'customer_email' => 'john@example.com',
                'sku' => 'SKU001',
                'name' => 'Product Name',
                'store_id' => 1
            ]
        ];

        $this->resourceModelMock->expects(self::once())
            ->method('getReviewReminderCollectedData')
            ->with($reviewReminderMock)
            ->willReturn($expectedData);

        $result = $this->subject->execute($reviewReminderMock);

        $this->assertArrayHasKey(0, $result);
        $this->assertArrayHasKey('customer_firstname', $result[0]);
        $this->assertArrayHasKey('customer_lastname', $result[0]);
        $this->assertArrayHasKey('customer_email', $result[0]);
        $this->assertArrayHasKey('sku', $result[0]);
        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayHasKey('store_id', $result[0]);
    }
}
