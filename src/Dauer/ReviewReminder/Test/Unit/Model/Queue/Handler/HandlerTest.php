<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Test\Unit\Model\Queue\Handler;

use Dauer\ReviewReminder\Model\Queue\Handler\Handler;
use Dauer\ReviewReminderApi\Api\Command\Mail\SentReviewReminderMailInterface;
use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Dauer\ReviewReminderApi\Api\ReviewReminderRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\SerializerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class HandlerTest extends TestCase
{
    private Handler $handler;
    private SerializerInterface|MockObject $serializerMock;
    private SentReviewReminderMailInterface|MockObject $sentReviewReminderMailMock;
    private ReviewReminderRepositoryInterface|MockObject $reviewReminderRepositoryMock;
    private ReviewReminderInterface|MockObject $reviewReminderMock;

    protected function setUp(): void
    {
        $this->serializerMock = $this->createMock(SerializerInterface::class);
        $this->sentReviewReminderMailMock = $this->createMock(SentReviewReminderMailInterface::class);
        $this->reviewReminderRepositoryMock = $this->createMock(ReviewReminderRepositoryInterface::class);
        $this->reviewReminderMock = $this->createMock(ReviewReminderInterface::class);

        $this->handler = new Handler(
            $this->serializerMock,
            $this->sentReviewReminderMailMock,
            $this->reviewReminderRepositoryMock
        );
    }

    /**
     * Test execute with single customer
     */
    public function testExecuteSuccessfully(): void
    {
        $reviewId = 42;
        $rawData = '{"data": {"review_id": 42, "customer_data": [{"customer_firstname": "João", "customer_lastname": "Silva", "customer_email": "joao@example.com"}]}}';

        $unserializedData = [
            'data' => [
                'review_id' => 42,
                'customer_data' => [
                    [
                        'customer_firstname' => 'João',
                        'customer_lastname' => 'Silva',
                        'customer_email' => 'joao@example.com'
                    ]
                ]
            ]
        ];

        $this->serializerMock
            ->expects(self::once())
            ->method('unserialize')
            ->with($rawData)
            ->willReturn($unserializedData);

        $this->sentReviewReminderMailMock
            ->expects(self::once())
            ->method('execute');

        $this->reviewReminderRepositoryMock
            ->expects(self::once())
            ->method('getReviewReminder')
            ->with($reviewId)
            ->willReturn($this->reviewReminderMock);

        $this->reviewReminderMock
            ->expects(self::once())
            ->method('setEmailUsed')
            ->with(true)
            ->willReturnSelf();

        $this->reviewReminderRepositoryMock
            ->expects(self::once())
            ->method('saveReviewReminder')
            ->with($this->reviewReminderMock);

        $this->handler->execute($rawData);
    }

    /**
     * Test execute with multiple customers
     */
    public function testExecuteWithMultipleCustomers(): void
    {
        $reviewId = 42;
        $rawData = '{"data": {"review_id": 42, "customer_data": [{"customer_firstname": "João", "customer_lastname": "Silva", "customer_email": "joao@example.com"}, {"customer_firstname": "Maria", "customer_lastname": "Santos", "customer_email": "maria@example.com"}]}}';

        $unserializedData = [
            'data' => [
                'review_id' => 42,
                'customer_data' => [
                    [
                        'customer_firstname' => 'João',
                        'customer_lastname' => 'Silva',
                        'customer_email' => 'joao@example.com'
                    ],
                    [
                        'customer_firstname' => 'Maria',
                        'customer_lastname' => 'Santos',
                        'customer_email' => 'maria@example.com'
                    ]
                ]
            ]
        ];

        $this->serializerMock
            ->expects(self::once())
            ->method('unserialize')
            ->with($rawData)
            ->willReturn($unserializedData);

        $this->sentReviewReminderMailMock
            ->expects(self::exactly(2))
            ->method('execute');

        $this->reviewReminderRepositoryMock
            ->expects(self::once())
            ->method('getReviewReminder')
            ->with($reviewId)
            ->willReturn($this->reviewReminderMock);

        $this->reviewReminderMock
            ->expects(self::once())
            ->method('setEmailUsed')
            ->with(true)
            ->willReturnSelf();

        $this->reviewReminderRepositoryMock
            ->expects(self::once())
            ->method('saveReviewReminder')
            ->with($this->reviewReminderMock);

        $this->handler->execute($rawData);
    }

    /**
     * Test execute with serializer exception
     */
    public function testExecuteWithSerializerException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $data = 'invalid-json';

        $this->serializerMock
            ->expects(self::once())
            ->method('unserialize')
            ->with($data)
            ->willThrowException(new \InvalidArgumentException('Invalid JSON'));

        $this->sentReviewReminderMailMock
            ->expects(self::never())
            ->method('execute');

        $this->reviewReminderRepositoryMock
            ->expects(self::never())
            ->method('getReviewReminder');

        $this->handler->execute($data);
    }

    /**
     * Test execute with email sending exception
     */
    public function testExecuteWithEmailException(): void
    {
        $this->expectException(LocalizedException::class);

        $rawData = '{"data": {"review_id": 42, "customer_data": [{"customer_firstname": "João", "customer_lastname": "Silva", "customer_email": "joao@example.com"}]}}';

        $unserializedData = [
            'data' => [
                'review_id' => 42,
                'customer_data' => [
                    [
                        'customer_firstname' => 'João',
                        'customer_lastname' => 'Silva',
                        'customer_email' => 'joao@example.com'
                    ]
                ]
            ]
        ];

        $this->serializerMock
            ->expects(self::once())
            ->method('unserialize')
            ->willReturn($unserializedData);

        $this->sentReviewReminderMailMock
            ->expects(self::once())
            ->method('execute')
            ->willThrowException(new LocalizedException(__('Email sending failed')));

        $this->reviewReminderRepositoryMock
            ->expects(self::never())
            ->method('getReviewReminder');

        $this->handler->execute($rawData);
    }
}
