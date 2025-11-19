<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Test\Unit\Model\Command;

use Dauer\ReviewReminder\Model\Command\DeleteReviewReminderCommand;
use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResource;
use Dauer\ReviewReminder\Model\ReviewReminder;
use Dauer\ReviewReminderApi\Api\Command\GetReviewReminderCommandInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Exception;
use PHPUnit\Framework\TestCase;

class DeleteReviewReminderCommandTest extends TestCase
{
    private DeleteReviewReminderCommand $subject;
    private ReviewReminderResource $resourceModelMock;
    private GetReviewReminderCommandInterface $commandGetMock;

    protected function setUp(): void
    {
        $this->resourceModelMock = $this->createMock(ReviewReminderResource::class);
        $this->commandGetMock = $this->createMock(GetReviewReminderCommandInterface::class);

        $this->subject = new DeleteReviewReminderCommand(
            $this->resourceModelMock,
            $this->commandGetMock
        );
    }

    public function testExecuteSuccessfully(): void
    {
        $entityId = 1;
        $reviewReminderMock = $this->createMock(ReviewReminder::class);

        $this->commandGetMock->expects(self::once())
            ->method('execute')
            ->with($entityId)
            ->willReturn($reviewReminderMock);

        $this->resourceModelMock->expects(self::once())
            ->method('delete')
            ->with($reviewReminderMock);

        $this->subject->execute($entityId);
    }

    public function testExecuteWithDifferentEntityIds(): void
    {
        $entityId1 = 5;
        $entityId2 = 10;

        $reviewReminder1Mock = $this->createMock(ReviewReminder::class);
        $reviewReminder2Mock = $this->createMock(ReviewReminder::class);

        $callCount = 0;
        $this->commandGetMock->expects(self::exactly(2))
            ->method('execute')
            ->willReturnCallback(function($entityId) use (&$callCount, $entityId1, $entityId2, $reviewReminder1Mock, $reviewReminder2Mock) {
                $callCount++;
                if ($callCount === 1) {
                    $this->assertEquals($entityId1, $entityId);
                    return $reviewReminder1Mock;
                } else {
                    $this->assertEquals($entityId2, $entityId);
                    return $reviewReminder2Mock;
                }
            });

        $deleteCallCount = 0;
        $this->resourceModelMock->expects(self::exactly(2))
            ->method('delete')
            ->willReturnCallback(function($reviewReminder) use (&$deleteCallCount, $reviewReminder1Mock, $reviewReminder2Mock) {
                $deleteCallCount++;
                if ($deleteCallCount === 1) {
                    $this->assertSame($reviewReminder1Mock, $reviewReminder);
                } else {
                    $this->assertSame($reviewReminder2Mock, $reviewReminder);
                }
            });

        $this->subject->execute($entityId1);
        $this->subject->execute($entityId2);
    }

    public function testExecuteThrowsCouldNotDeleteExceptionOnResourceModelException(): void
    {
        $entityId = 1;
        $errorMessage = 'Database error occurred';
        $reviewReminderMock = $this->createMock(ReviewReminder::class);

        $this->commandGetMock->expects(self::once())
            ->method('execute')
            ->with($entityId)
            ->willReturn($reviewReminderMock);

        $this->resourceModelMock->expects(self::once())
            ->method('delete')
            ->with($reviewReminderMock)
            ->willThrowException(new Exception($errorMessage));

        $this->expectException(CouldNotDeleteException::class);
        $this->expectExceptionMessage($errorMessage);

        $this->subject->execute($entityId);
    }

    public function testExecuteThrowsCouldNotDeleteExceptionOnGetCommandException(): void
    {
        $entityId = 1;
        $errorMessage = 'Review reminder not found';

        $this->commandGetMock->expects(self::once())
            ->method('execute')
            ->with($entityId)
            ->willThrowException(new Exception($errorMessage));

        $this->resourceModelMock->expects(self::never())
            ->method('delete');

        $this->expectException(CouldNotDeleteException::class);
        $this->expectExceptionMessage($errorMessage);

        $this->subject->execute($entityId);
    }

    public function testExecuteCallsGetCommandBeforeDelete(): void
    {
        $entityId = 1;
        $reviewReminderMock = $this->createMock(ReviewReminder::class);

        $callOrder = [];

        $this->commandGetMock->expects(self::once())
            ->method('execute')
            ->with($entityId)
            ->willReturnCallback(function() use (&$callOrder, $reviewReminderMock) {
                $callOrder[] = 'get';
                return $reviewReminderMock;
            });

        $this->resourceModelMock->expects(self::once())
            ->method('delete')
            ->with($reviewReminderMock)
            ->willReturnCallback(function() use (&$callOrder) {
                $callOrder[] = 'delete';
            });

        $this->subject->execute($entityId);

        $this->assertEquals(['get', 'delete'], $callOrder);
    }

    public function testExecuteWithZeroEntityId(): void
    {
        $entityId = 0;
        $reviewReminderMock = $this->createMock(ReviewReminder::class);

        $this->commandGetMock->expects(self::once())
            ->method('execute')
            ->with($entityId)
            ->willReturn($reviewReminderMock);

        $this->resourceModelMock->expects(self::once())
            ->method('delete')
            ->with($reviewReminderMock);

        $this->subject->execute($entityId);
    }

    public function testExecuteWithLargeEntityId(): void
    {
        $entityId = 999999;
        $reviewReminderMock = $this->createMock(ReviewReminder::class);

        $this->commandGetMock->expects(self::once())
            ->method('execute')
            ->with($entityId)
            ->willReturn($reviewReminderMock);

        $this->resourceModelMock->expects(self::once())
            ->method('delete')
            ->with($reviewReminderMock);

        $this->subject->execute($entityId);
    }

    public function testExecuteDoesNotReturnValue(): void
    {
        $entityId = 1;
        $reviewReminderMock = $this->createMock(ReviewReminder::class);

        $this->commandGetMock->expects(self::once())
            ->method('execute')
            ->with($entityId)
            ->willReturn($reviewReminderMock);

        $this->resourceModelMock->expects(self::once())
            ->method('delete')
            ->with($reviewReminderMock);

        $result = $this->subject->execute($entityId);

        $this->assertNull($result);
    }

    public function testExecuteWithMultipleExceptionTypes(): void
    {
        $entityId = 1;
        $exceptionMessage = 'Integrity constraint violation';
        $reviewReminderMock = $this->createMock(ReviewReminder::class);

        $this->commandGetMock->expects(self::once())
            ->method('execute')
            ->with($entityId)
            ->willReturn($reviewReminderMock);

        $this->resourceModelMock->expects(self::once())
            ->method('delete')
            ->with($reviewReminderMock)
            ->willThrowException(new Exception($exceptionMessage));

        $this->expectException(CouldNotDeleteException::class);

        $this->subject->execute($entityId);
    }
}
