<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\GiftMessagePlus\Model\Config\Data;

use Dauer\GiftMessagePlusApi\Api\Data\Config\EditorConfigDataInterface;
use Magento\Framework\DataObject;

/**
 * Editor config data implementation.
 *
 * Don't need to test data class.
 * @codeCoverageIgnore
 */
class EditorConfigData extends DataObject implements EditorConfigDataInterface
{
    private const string CSS_SELECTOR_KEY = 'css_selector';
    private const string PLUGIN_LIST_KEY = 'plugin_list';
    private const string MODE_KEY = 'mode';
    private const string ADDITIONAL_SETTINGS_KEY = 'additional_settings';

    /**
     * @inheritDoc
     */
    public function setCssSelector(string $cssSelector): void
    {
        $this->setData(self::CSS_SELECTOR_KEY, $cssSelector);
    }

    /**
     * @inheritDoc
     */
    public function getCssSelector(): string
    {
        return (string) $this->getData(self::CSS_SELECTOR_KEY);
    }

    /**
     * @inheritDoc
     */
    public function setPluginList(array $pluginList): void
    {
        $this->setData(self::PLUGIN_LIST_KEY, $pluginList);
    }

    /**
     * @inheritDoc
     */
    public function getPluginList(): string
    {
        $data = $this->getData(self::PLUGIN_LIST_KEY);

        if (empty($data) || !is_array($data)) {
            return '';
        }

        return implode(',', $data);
    }

    /**
     * @inheritDoc
     */
    public function setMode(string $mode): void
    {
        $this->setData(self::MODE_KEY, $mode);
    }

    /**
     * @inheritDoc
     */
    public function getMode(): string
    {
        return (string) $this->getData(self::MODE_KEY);
    }

    /**
     * @inheritDoc
     */
    public function setAdditionalSettings(array $additionalSettings): void
    {
        $this->setData(self::ADDITIONAL_SETTINGS_KEY, $additionalSettings);
    }

    /**
     * @inheritDoc
     */
    public function getAdditionalSettings(): array
    {
        return (array) $this->getData(self::ADDITIONAL_SETTINGS_KEY);
    }
}
