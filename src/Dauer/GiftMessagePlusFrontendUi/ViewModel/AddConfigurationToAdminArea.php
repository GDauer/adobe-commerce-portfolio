<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\GiftMessagePlusFrontendUi\ViewModel;

use Dauer\GiftMessagePlus\Model\Checkout\ConfigProvider\GiftMessageConfig;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * View Model to add configurations to the admin area.
 */
class AddConfigurationToAdminArea implements ArgumentInterface
{
    /**
     * Class construct.
     *
     * @param GiftMessageConfig $giftMessageConfig
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private GiftMessageConfig $giftMessageConfig,
        private SerializerInterface $serializer
    ) {
    }

    /**
     * Return checkout config serialized.
     *
     * @return string
     */
    public function getGiftMessageConfig(): string
    {
        return $this->serializer->serialize($this->giftMessageConfig->getConfig());
    }
}
