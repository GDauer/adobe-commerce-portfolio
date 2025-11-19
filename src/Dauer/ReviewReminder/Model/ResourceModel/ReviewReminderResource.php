<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model\ResourceModel;

use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Resource Class
 * @codeCoverageIgnore
 */
class ReviewReminderResource extends AbstractDb
{
    /**
     * @var string
     */
    protected string $_eventPrefix = 'dauer_review_reminder_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct(): void
    {
        $this->_init('dauer_review_reminder', 'entity_id');
        $this->_useIsObjectNew = true;
    }

    /**
     * Return collected data.
     *
     * @param ReviewReminderInterface $reviewReminder
     *
     * @return array
     */
    public function getReviewReminderCollectedData(ReviewReminderInterface $reviewReminder): array
    {
        $connection = $this->getConnection();
        $select = $connection->select();

        $select->from(
            ['so' => $connection->getTableName('sales_order')],
            [
                'so.customer_firstname',
                'so.customer_lastname',
                'so.customer_email',
                'sii.sku',
                'sii.name'
            ]
        );
        $select->joinInner(
            ['si' => $connection->getTableName('sales_invoice')],
            'so.entity_id = si.order_id',
        );
        $select->joinInner(
            ['sii' => $connection->getTableName('sales_invoice_item')],
            'si.entity_id = sii.parent_id',
        );

        if (!empty($reviewReminder->getProductSkusArray())) {
            $select->where('sii.sku IN (?)', $reviewReminder->getProductSkusArray());
        }

        if (!empty($reviewReminder->getCustomerGroupId())) {
            $select->where('so.customer_group_id = ?', $reviewReminder->getCustomerGroupId());
        }

        $select->where('si.created_at >= ?', $reviewReminder->getStartDate());
        $select->where('si.created_at <= ?', $reviewReminder->getEndDate());

        return $connection->fetchAssoc($select);
    }
}
