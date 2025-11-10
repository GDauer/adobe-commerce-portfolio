<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\GiftMessagePlusApi\Api\Data\Config;

/**
 * Editor config data
 */
interface EditorConfigDataInterface
{
    /**
     * CSS Selector setter.
     *
     * @param string $cssSelector
     *
     * @return void
     */
    public function setCssSelector(string $cssSelector): void;

    /**
     * CSS Selector getter.
     *
     * @return string
     */
    public function getCssSelector(): string;

    /**
     * Plugin list setter.
     *
     * @param array $pluginList
     *
     * @return void
     */
    public function setPluginList(array $pluginList): void;

    /**
     * Plugin list getter.
     *
     * @return string
     */
    public function getPluginList(): string;

    /**
     * Mode setter.
     *
     * @param string $mode
     *
     * @return void
     */
    public function setMode(string $mode): void;

    /**
     * Mode getter.
     *
     * @return string
     */
    public function getMode(): string;

    /**
     * Steer additional setting.
     *
     * @param array $additionalSettings
     *
     * @return void
     */
    public function setAdditionalSettings(array $additionalSettings): void;

    /**
     * Getter additional settings.
     *
     * @return array
     */
    public function getAdditionalSettings(): array;
}
