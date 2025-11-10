<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\GiftMessagePlus\Model\Config;

use Dauer\GiftMessagePlusApi\Api\Config\ConfigProviderInterface;
use Dauer\GiftMessagePlusApi\Api\Data\Config\EditorConfigDataInterface;
use Dauer\GiftMessagePlusApi\Api\Data\Config\EditorConfigDataInterfaceFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Implements Config Interface
 */
class ConfigProvider implements ConfigProviderInterface
{
    private const string CONFIG_PATH_ENABLED = 'sales/gift_options/gift_message_plus/enabled';
    private const string CONFIG_PATH_MAX_LENGTH = 'sales/gift_options/gift_message_plus/max_length';

    /**
     * Config Provider construct.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param EditorConfigDataFactory $configDataInterfaceFactory
     * @param array $plugins
     * @param array $additionalSettings
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly EditorConfigDataInterfaceFactory $configDataInterfaceFactory,
        private readonly array $plugins,
        private readonly array $additionalSettings
    ) {
    }

    /**
     * @inheritDoc
     */
    public function isGiftMessagePlusEnabled(int $storeId = 0): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::CONFIG_PATH_ENABLED,
            ScopeInterface::SCOPE_WEBSITE,
            $storeId
        );
    }

    /**
     * @inheritDoc
     */
    public function getMessageMaxLength(int $storeId = 0): int
    {
        return (int) $this->scopeConfig->getValue(
            self::CONFIG_PATH_MAX_LENGTH,
            ScopeInterface::SCOPE_WEBSITE,
            $storeId
        );
    }

    /**
     * @inheirtDoc
     */
    public function getEditorConfiguration(): EditorConfigDataInterface
    {
        /** @var EditorConfigDataInterface $editorConfiguration */
        $editorConfiguration = $this->configDataInterfaceFactory->create();

        $editorConfiguration->setCssSelector('gift-message-whole-message-');
        $editorConfiguration->setPluginList($this->plugins);
        $editorConfiguration->setMode('exact');
        $editorConfiguration->setAdditionalSettings($this->additionalSettings);

        return $editorConfiguration;
    }
}
