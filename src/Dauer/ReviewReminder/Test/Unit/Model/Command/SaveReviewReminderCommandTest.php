<?php
/**
 * Unit test for SaveReviewReminderCommand
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Test\Unit\Model\Command;

use Dauer\ReviewReminder\Model\Command\SaveReviewReminderCommand;
use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResource;
use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResourceFactory as ReviewReminderResourceFactory;
use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Model\AbstractModel;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SaveReviewReminderCommandTest extends TestCase
{
    private SaveReviewReminderCommand $command;
    private ReviewReminderResourceFactory|MockObject $resourceFactoryMock;
    private ReviewReminderResource|MockObject $resourceMock;
    private AbstractModel|ReviewReminderInterface|MockObject $reminderMock;

    protected function setUp(): void
    {
        $this->resourceFactoryMock = $this->createMock(ReviewReminderResourceFactory::class);
        $this->resourceMock = $this->createMock(ReviewReminderResource::class);
        $this->reminderMock = $this->getMockForAbstractClass(
            \Dauer\ReviewReminder\Model\ReviewReminder::class,
            [],
            '',
            false,
            false,
            true,
            ['getProductSkusArray', 'getCustomerGroupId', 'getStartDate', 'getEndDate']
        );

        $this->command = new SaveReviewReminderCommand(
            $this->resourceFactoryMock
        );
    }

    /**
     * Test that execute saves the model and returns it successfully
     */
    public function testExecuteSavesAndReturnsModel(): void
    {
        $this->resourceFactoryMock->expects(self::once())
            ->method('create')
            ->willReturn($this->resourceMock);

        $this->resourceMock->expects(self::once())
            ->method('save')
            ->with($this->reminderMock);

        $result = $this->command->execute($this->reminderMock);

        $this->assertSame($this->reminderMock, $result);
    }

    /**
     * Test that execute throws CouldNotSaveException when resource save fails
     */
    public function testExecuteThrowsCouldNotSaveExceptionOnSaveFailure(): void
    {
        $errorMessage = 'Database connection failed';

        $this->resourceFactoryMock->method('create')->willReturn($this->resourceMock);
        $this->resourceMock->method('save')
            ->willThrowException(new \Exception($errorMessage));

        $this->expectException(CouldNotSaveException::class);
        $this->expectExceptionMessage($errorMessage);

        $this->command->execute($this->reminderMock);
    }
}
