<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\Command;

use Dauer\ReviewReminderApi\Api\Command\GetCustomerListForDispatchCommandInterface;
use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Dauer\ReviewReminderApi\Api\ReviewReminderRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;

/**
 * Get a list for dispatch command.
 */
class GetCustomerListForDispatchCommand implements GetCustomerListForDispatchCommandInterface
{
    private const bool EMAIL_STATE_NOT_SENT = false;

    /**
     * Construct method.
     *
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $builder
     * @param ReviewReminderRepositoryInterface $reviewReminderRepository
     */
    public function __construct(
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly FilterBuilder $builder,
        private readonly ReviewReminderRepositoryInterface $reviewReminderRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(): array
    {
        $this->builder->setField(ReviewReminderInterface::IS_EMAIL_SENT);
        $this->builder->setValue(self::EMAIL_STATE_NOT_SENT);
        $this->builder->setConditionType('eq');
        $this->searchCriteriaBuilder->addFilter($this->builder->create());

        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->reviewReminderRepository->getList($searchCriteria);
    }
}
