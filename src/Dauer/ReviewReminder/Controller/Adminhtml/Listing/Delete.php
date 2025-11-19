<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Controller\Adminhtml\Listing;

use Dauer\ReviewReminderApi\Api\ReviewReminderRepositoryInterface;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Post action to save Review settings.
 * @codeCoverageIgnore
 */
class Delete extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    public const ADMIN_RESOURCE = 'Dauer_ReviewReminder::manage';

    /**
     * Construct method.
     *
     * @param Context $context
     * @param ReviewReminderRepositoryInterface $reviewReminderRepository
     */
    public function __construct(
        Context $context,
        private readonly ReviewReminderRepositoryInterface $reviewReminderRepository
    ) {
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        try {
            $this->reviewReminderRepository->deleteReviewReminder((int) $this->getRequest()->getParam('entity_id'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        $this->messageManager->addSuccessMessage(__('The review reminder has been successfully deleted.'));
        return $this->resultRedirectFactory->create()->setPath('reviewreminder/listing/index');
    }
}
