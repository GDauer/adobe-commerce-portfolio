<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Controller\Adminhtml\Listing;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Listing action
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     */
    public const ADMIN_RESOURCE = 'Dauer_ReviewReminder::listing';

    /**
     * Execute action based on a request and return result
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute(): ResultInterface|ResponseInterface
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
