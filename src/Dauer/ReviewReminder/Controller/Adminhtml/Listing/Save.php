<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Controller\Adminhtml\Listing;

use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Dauer\ReviewReminderApi\Api\ReviewReminderRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Post action to save Review settings.
 */
class Save extends Action implements HttpPostActionInterface
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
     * Execute action based on a request and return result
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        try {
            $params = $this->_request->getParam('general');
            $entityId = (int)$params[ReviewReminderInterface::ENTITY_ID];
            $reminder = $this->reviewReminderRepository->getReviewReminder($entityId);

            $reminder->setIdentifier((string)$params[ReviewReminderInterface::IDENTIFIER]);
            $reminder->setCustomerGroupId($params[ReviewReminderInterface::CUSTOMER_GROUP_ID] ?: null);
            $reminder->setProductSkusArray(explode(',', $params[ReviewReminderInterface::PRODUCT_SKUS]));
            $reminder->setStartDate((string)$params[ReviewReminderInterface::START_DATE]);
            $reminder->setEndDate((string)$params[ReviewReminderInterface::END_DATE]);
            $reminder->setEmailUsed((bool)$params[ReviewReminderInterface::IS_EMAIL_SENT]);

            $this->reviewReminderRepository->saveReviewReminder($reminder);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }

        $this->messageManager->addSuccessMessage(__('The review reminder has been successfully saved.'));
        return $this->resultRedirectFactory->create()->setPath('reviewreminder/listing/index');
    }
}
