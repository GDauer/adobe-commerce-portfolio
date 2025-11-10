<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminderApi\Api\Command;

use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Magento\Framework\Api\Search\SearchCriteriaInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Get List command
 */
interface GetListReviewReminderCommandInterface
{
    /**
     * Saves an object and return after.
     *
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @throws NotFoundException
     * @return ReviewReminderInterface[]
     */
    public function execute(SearchCriteriaInterface $searchCriteria): array;
}
