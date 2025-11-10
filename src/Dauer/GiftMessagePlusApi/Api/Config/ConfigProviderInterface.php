<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\GiftMessagePlusApi\Api\Config;

use Dauer\GiftMessagePlusApi\Api\Data\Config\EditorConfigDataInterface;

/**
 * Interface for system config provider
 */
interface ConfigProviderInterface
{
    /**
     * Return if the module is enabled in the provided scope.
     *
     * @param int $storeId
     *
     * @return bool
     */
    public function isGiftMessagePlusEnabled(int $storeId = 0): bool;

    /**
     * Return the max length configured for gift message.
     *
     * @param int $storeId
     *
     * @return int
     */
    public function getMessageMaxLength(int $storeId = 0): int;

    /**
     * Return editor configuration.
     *
     * @return EditorConfigDataInterface
     */
    public function getEditorConfiguration(): EditorConfigDataInterface;
}
