<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Block\Adminhtml\Form;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Back to list button.
 */
readonly class CancelButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Cancel'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for cancel action
     *
     * @return string
     */
    private function getBackUrl(): string
    {
        return $this->getUrl('*/*/');
    }
}
