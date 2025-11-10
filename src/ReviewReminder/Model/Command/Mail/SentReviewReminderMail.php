<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Command\Mail;

use Dauer\ReviewReminderApi\Api\Command\Mail\SentReviewReminderMailInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;

/**
 * Sent mail message command
 */
readonly class SentReviewReminderMail implements SentReviewReminderMailInterface
{
    /**
     * Construct method.
     *
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private TransportBuilder $transportBuilder,
        private ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(array $templateVars): void
    {
        $emailTemplate = $this->scopeConfig->getValue('review/email/review_mail/template');
        $emailSender = $this->scopeConfig->getValue('review/email/review_mail/identity');

        $transport = $this->transportBuilder->setTemplateIdentifier($emailTemplate)
            ->setTemplateOptions(['area' => 'frontend', 'store' => 0])
            ->setTemplateVars($templateVars)
            ->setFromByScope($emailSender)
            ->addTo($templateVars['customer_email'])
            ->getTransport();

        $transport->sendMessage();
    }
}
