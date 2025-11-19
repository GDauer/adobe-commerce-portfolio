<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Test\Unit\Model\Command\Mail;

use Dauer\ReviewReminder\Model\Command\Mail\SentReviewReminderMail;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Mail\TransportInterface;
use Magento\Store\Model\ScopeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SentReviewReminderMailTest extends TestCase
{
    private SentReviewReminderMail $sentReviewReminderMail;
    private TransportBuilder|MockObject $transportBuilderMock;
    private ScopeConfigInterface|MockObject $scopeConfigMock;
    private TransportInterface|MockObject $transportMock;

    protected function setUp(): void
    {
        $this->transportBuilderMock = $this->createMock(TransportBuilder::class);
        $this->scopeConfigMock = $this->createMock(ScopeConfigInterface::class);
        $this->transportMock = $this->createMock(TransportInterface::class);

        $this->sentReviewReminderMail = new SentReviewReminderMail(
            $this->transportBuilderMock,
            $this->scopeConfigMock
        );
    }

    /**
     * Test execute successfully with complete data
     */
    public function testExecuteSuccessfully(): void
    {
        $templateVars = [
            'customer_name' => 'João Silva',
            'customer_email' => 'joao@example.com',
            'product_name' => 'Produto Teste',
            'order_increment_id' => '000000001',
            'store_id' => 1
        ];

        $emailTemplate = 'review_reminder_template';
        $emailSender = 'general';

        $this->expectScopeConfigCalls($templateVars['store_id'], $emailTemplate, $emailSender);
        $this->expectTransportBuilderCalls($templateVars, $emailTemplate, $emailSender);
        $this->expectTransportSendMessage();

        $this->sentReviewReminderMail->execute($templateVars);
    }

    /**
     * Test execute with minimal data
     */
    public function testExecuteWithMinimalData(): void
    {
        $templateVars = [
            'customer_email' => 'maria@example.com',
            'store_id' => 2
        ];

        $emailTemplate = 'default_template';
        $emailSender = 'support';

        $this->expectScopeConfigCalls($templateVars['store_id'], $emailTemplate, $emailSender);
        $this->expectTransportBuilderCalls($templateVars, $emailTemplate, $emailSender);
        $this->expectTransportSendMessage();

        $this->sentReviewReminderMail->execute($templateVars);
    }

    /**
     * Test execute with special characters in data
     */
    public function testExecuteWithSpecialCharacters(): void
    {
        $templateVars = [
            'customer_name' => 'José María Ñoño',
            'customer_email' => 'jose.maria@example.com',
            'store_id' => 1
        ];

        $emailTemplate = 'special_template';
        $emailSender = 'sales';

        $this->expectScopeConfigCalls($templateVars['store_id'], $emailTemplate, $emailSender);
        $this->expectTransportBuilderCalls($templateVars, $emailTemplate, $emailSender);
        $this->expectTransportSendMessage();

        $this->sentReviewReminderMail->execute($templateVars);
    }

    /**
     * Test that transport builder methods are called in correct order
     */
    public function testExecuteCallsMethodsInCorrectOrder(): void
    {
        $templateVars = [
            'customer_email' => 'test@example.com',
            'store_id' => 1
        ];

        $callOrder = [];

        $this->scopeConfigMock
            ->expects(self::exactly(2))
            ->method('getValue')
            ->willReturnCallback(function ($path) use (&$callOrder) {
                $callOrder[] = 'getValue:' . $path;
                return $path === 'review/email/review_mail/template' ? 'template' : 'sender';
            });

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('setTemplateIdentifier')
            ->willReturnCallback(function () use (&$callOrder) {
                $callOrder[] = 'setTemplateIdentifier';
                return $this->transportBuilderMock;
            });

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('setTemplateOptions')
            ->willReturnCallback(function () use (&$callOrder) {
                $callOrder[] = 'setTemplateOptions';
                return $this->transportBuilderMock;
            });

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('setTemplateVars')
            ->willReturnCallback(function () use (&$callOrder) {
                $callOrder[] = 'setTemplateVars';
                return $this->transportBuilderMock;
            });

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('setFromByScope')
            ->willReturnCallback(function () use (&$callOrder) {
                $callOrder[] = 'setFromByScope';
                return $this->transportBuilderMock;
            });

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('addTo')
            ->willReturnCallback(function () use (&$callOrder) {
                $callOrder[] = 'addTo';
                return $this->transportBuilderMock;
            });

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('getTransport')
            ->willReturnCallback(function () use (&$callOrder) {
                $callOrder[] = 'getTransport';
                return $this->transportMock;
            });

        $this->transportMock
            ->expects(self::once())
            ->method('sendMessage')
            ->willReturnCallback(function () use (&$callOrder) {
                $callOrder[] = 'sendMessage';
            });

        $this->sentReviewReminderMail->execute($templateVars);

        // Verify the getValue calls happened first
        $this->assertStringContainsString('review/email/review_mail/template', $callOrder[0]);
        $this->assertStringContainsString('review/email/review_mail/identity', $callOrder[1]);
    }

    /**
     * Test that correct scope is used when getting config values
     */
    public function testExecuteUsesCorrectScope(): void
    {
        $storeId = 5;
        $templateVars = [
            'customer_email' => 'customer@example.com',
            'store_id' => $storeId
        ];

        $this->scopeConfigMock
            ->expects(self::exactly(2))
            ->method('getValue')
            ->with(
                self::anything(),
                ScopeInterface::SCOPE_STORE,
                $storeId
            )
            ->willReturn('value');

        $this->transportBuilderMock->method('getTransport')->willReturn($this->transportMock);
        $this->transportMock->method('sendMessage');

        $this->sentReviewReminderMail->execute($templateVars);
    }

    /**
     * Test that correct email is passed to addTo method
     */
    public function testExecuteAddsCorrectEmailAddress(): void
    {
        $email = 'specific@example.com';
        $templateVars = [
            'customer_email' => $email,
            'store_id' => 1
        ];

        $this->scopeConfigMock->method('getValue')->willReturn('template_or_sender');

        $this->transportBuilderMock->method('setTemplateIdentifier')->willReturnSelf();
        $this->transportBuilderMock->method('setTemplateOptions')->willReturnSelf();
        $this->transportBuilderMock->method('setTemplateVars')->willReturnSelf();
        $this->transportBuilderMock->method('setFromByScope')->willReturnSelf();

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('addTo')
            ->with($email)
            ->willReturnSelf();

        $this->transportBuilderMock->method('getTransport')->willReturn($this->transportMock);
        $this->transportMock->method('sendMessage');

        $this->sentReviewReminderMail->execute($templateVars);
    }

    /**
     * Test that template options include correct area and store
     */
    public function testExecuteUsesCorrectTemplateOptions(): void
    {
        $storeId = 3;
        $templateVars = [
            'customer_email' => 'test@example.com',
            'store_id' => $storeId
        ];

        $this->scopeConfigMock->method('getValue')->willReturn('template_or_sender');
        $this->transportBuilderMock->method('setTemplateIdentifier')->willReturnSelf();

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('setTemplateOptions')
            ->with(['area' => 'frontend', 'store' => $storeId])
            ->willReturnSelf();

        $this->transportBuilderMock->method('setTemplateVars')->willReturnSelf();
        $this->transportBuilderMock->method('setFromByScope')->willReturnSelf();
        $this->transportBuilderMock->method('addTo')->willReturnSelf();
        $this->transportBuilderMock->method('getTransport')->willReturn($this->transportMock);
        $this->transportMock->method('sendMessage');

        $this->sentReviewReminderMail->execute($templateVars);
    }

    /**
     * Helper: Setup scopeConfig mock expectations
     */
    private function expectScopeConfigCalls(int $storeId, string $template, string $sender): void
    {
        $this->scopeConfigMock
            ->expects(self::exactly(2))
            ->method('getValue')
            ->willReturnMap([
                ['review/email/review_mail/template', ScopeInterface::SCOPE_STORE, $storeId, $template],
                ['review/email/review_mail/identity', ScopeInterface::SCOPE_STORE, $storeId, $sender]
            ]);
    }

    /**
     * Helper: Setup transportBuilder mock expectations
     */
    private function expectTransportBuilderCalls(array $templateVars, string $template, string $sender): void
    {
        $this->transportBuilderMock
            ->expects(self::once())
            ->method('setTemplateIdentifier')
            ->with($template)
            ->willReturnSelf();

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('setTemplateOptions')
            ->with(['area' => 'frontend', 'store' => $templateVars['store_id']])
            ->willReturnSelf();

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('setTemplateVars')
            ->with($templateVars)
            ->willReturnSelf();

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('setFromByScope')
            ->with($sender)
            ->willReturnSelf();

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('addTo')
            ->with($templateVars['customer_email'])
            ->willReturnSelf();

        $this->transportBuilderMock
            ->expects(self::once())
            ->method('getTransport')
            ->willReturn($this->transportMock);
    }

    /**
     * Helper: Setup transport mock expectations
     */
    private function expectTransportSendMessage(): void
    {
        $this->transportMock
            ->expects(self::once())
            ->method('sendMessage');
    }
}
