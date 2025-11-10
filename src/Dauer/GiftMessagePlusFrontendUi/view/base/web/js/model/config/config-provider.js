/**
 * @authro Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
define([
    'ko'
], function (ko) {
    'use strict';

    return {
        enabled: ko.observable(window.checkoutConfig.gift_message_plus.enabled),
        additionalSettings: ko.observable(window.checkoutConfig.gift_message_plus.additional_settings),
        maxLength: ko.observable(window.checkoutConfig.gift_message_plus.max_length),
        mode: ko.observable(window.checkoutConfig.gift_message_plus.editor_config.mode),
        plugins: ko.observable(window.checkoutConfig.gift_message_plus.editor_config.plugins),
        cssSelector: ko.observable(window.checkoutConfig.gift_message_plus.editor_config.css_selector)
    }
})
