<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\GiftMessagePlus\Model\Checkout\ConfigProvider;

use Dauer\GiftMessagePlusApi\Api\Config\ConfigProviderInterface as GiftMessageConfigProvider;
use Magento\Checkout\Model\ConfigProviderInterface;

/**
 * Configuration for gift messages Plus.
 */
class GiftMessageConfig implements ConfigProviderInterface
{
    /**
     * Gift message config construct.
     *
     * @param GiftMessageConfigProvider $configProvider
     */
    public function __construct(
        private readonly GiftMessageConfigProvider $configProvider,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getConfig(?int $storeId = 0): array
    {
        $editorConfiguration = $this->configProvider->getEditorConfiguration();

        return [
            'gift_message_plus' => [
                'enabled' => $this->configProvider->isGiftMessagePlusEnabled((int) $storeId),
                'max_length' => $this->configProvider->getMessageMaxLength((int) $storeId),
                'editor_config' => [
                    'mode' => $editorConfiguration->getMode(),
                    'plugins' => $editorConfiguration->getPluginList(),
                    'css_selector' => $editorConfiguration->getCssSelector()
                ],
                'additional_settings' => $editorConfiguration->getAdditionalSettings()
            ]
        ];
    }
}
