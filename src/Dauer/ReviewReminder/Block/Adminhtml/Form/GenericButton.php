<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Block\Adminhtml\Form;

use Magento\Backend\Block\Widget\Context;

/**
 * Class GenericButton
 */
readonly class GenericButton
{
    /**
     * Class construct.
     *
     * @param Context $context
     */
    public function __construct(
        private Context $context
    ) {
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     *
     * @return  string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
