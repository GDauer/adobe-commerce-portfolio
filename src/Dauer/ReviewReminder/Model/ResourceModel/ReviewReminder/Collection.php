<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\ResourceModel\ReviewReminder;

use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResource;
use Dauer\ReviewReminder\Model\ReviewReminder;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Collection.
 * @codeCoverageIgnore
 */
class Collection extends AbstractCollection
{
    protected $_eventPrefix = 'dauer_review_reminder_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct(): void
    {
        $this->_init(ReviewReminder::class, ReviewReminderResource::class);
    }
}
