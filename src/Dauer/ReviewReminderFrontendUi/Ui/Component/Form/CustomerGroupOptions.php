<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminderFrontendUi\Ui\Component\Form;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;

/**
 * Customer Group options
 * @codeCoverageIgnore
 */
readonly class CustomerGroupOptions implements OptionSourceInterface
{
    /**
     * Construct method.
     *
     * @param CollectionFactory $groupCollectionFactory
     */
    public function __construct(
        private CollectionFactory $groupCollectionFactory
    ) {
    }

    /**
     * @inheirtDoc
     */
    public function toOptionArray(): array
    {
        $collection = $this->groupCollectionFactory->create();
        $options = [['label' => __('All Customer Groups'), 'value' => '']];

        foreach ($collection as $group) {
            $options[] = [
                'label' => $group->getCustomerGroupCode(),
                'value' => $group->getCustomerGroupId()
            ];
        }

        return $options;
    }
}
