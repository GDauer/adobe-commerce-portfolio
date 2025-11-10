<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\GiftMessagePlusFrontendUi\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Remove script tags from the string
 *
 * Don't need to test PHP core function.
 * @codeCoverageIgnore
 */
readonly class RemoveScriptTags implements ArgumentInterface
{
    /**
     * Remove script tags.
     *
     * @param string $string
     *
     * @return string
     */
    public function removeScriptTags(string $string): string
    {
        return preg_replace('/(<script.?>)|(<img)|(<a\shref)/mi', '', $string);
    }
}
