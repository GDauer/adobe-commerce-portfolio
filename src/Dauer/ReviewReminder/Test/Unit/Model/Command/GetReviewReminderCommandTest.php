<?php
/**
 * Unit test for GetReviewReminderCommand
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Test\Unit\Model\Command;

use Dauer\ReviewReminder\Model\Command\GetReviewReminderCommand;
use Dauer\ReviewReminder\Model\ReviewReminder;
use Dauer\ReviewReminder\Model\ReviewReminderFactory;
use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResource;
use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResourceFactory as ReviewReminderResourceFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetReviewReminderCommandTest extends TestCase
{
    private GetReviewReminderCommand $command;
    private ReviewReminderResourceFactory|MockObject $resourceFactoryMock;
    private ReviewReminderFactory|MockObject $reminderFactoryMock;
    private ReviewReminderResource|MockObject $resourceMock;
    private ReviewReminder|MockObject $reminderMock;

    protected function setUp(): void
    {
        $this->resourceFactoryMock = $this->createMock(ReviewReminderResourceFactory::class);
        $this->reminderFactoryMock = $this->createMock(ReviewReminderFactory::class);
        $this->resourceMock = $this->createMock(ReviewReminderResource::class);
        $this->reminderMock = $this->createMock(ReviewReminder::class);

        $this->command = new GetReviewReminderCommand(
            $this->resourceFactoryMock,
            $this->reminderFactoryMock
        );
    }

    /**
     * Test that execute creates a new model and loads data from resource
     */
    public function testExecuteCreatesAndLoadsModel(): void
    {
        $entityId = 42;

        $this->reminderFactoryMock->expects(self::once())
            ->method('create')
            ->willReturn($this->reminderMock);

        $this->resourceFactoryMock->expects(self::once())
            ->method('create')
            ->willReturn($this->resourceMock);

        $this->resourceMock->expects(self::once())
            ->method('load')
            ->with($this->reminderMock, $entityId);

        $result = $this->command->execute($entityId);

        $this->assertSame($this->reminderMock, $result);
    }

    /**
     * Test that execute loads model with correct entity ID
     */
    public function testExecuteLoadsWithCorrectEntityId(): void
    {
        $entityId = 99;

        $this->reminderFactoryMock->method('create')->willReturn($this->reminderMock);
        $this->resourceFactoryMock->method('create')->willReturn($this->resourceMock);

        $this->resourceMock->expects(self::once())
            ->method('load')
            ->with($this->reminderMock, $entityId);

        $this->command->execute($entityId);
    }
}
