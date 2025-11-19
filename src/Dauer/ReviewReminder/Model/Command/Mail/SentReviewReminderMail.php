<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Command\Mail;

use Dauer\ReviewReminderApi\Api\Command\Mail\SentReviewReminderMailInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\ScopeInterface;

/**
 * Sent mail message command
 */
class SentReviewReminderMail implements SentReviewReminderMailInterface
{
    /**
     * Construct method.
     *
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly TransportBuilder $transportBuilder,
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(array $templateVars): void
    {
        $emailTemplate = $this->scopeConfig->getValue(
            'review/email/review_mail/template',
            ScopeInterface::SCOPE_STORE,
            $templateVars['store_id']
        );
        $emailSender = $this->scopeConfig->getValue(
            'review/email/review_mail/identity',
            ScopeInterface::SCOPE_STORE,
            $templateVars['store_id']
        );

        $this->transportBuilder->setTemplateIdentifier($emailTemplate);
        $this->transportBuilder->setTemplateOptions(['area' => 'frontend', 'store' => $templateVars['store_id']]);
        $this->transportBuilder->setTemplateVars($templateVars);
        $this->transportBuilder->setFromByScope($emailSender);
        $this->transportBuilder->addTo($templateVars['customer_email']);

        $transport = $this->transportBuilder->getTransport();

        $transport->sendMessage();
    }
}
