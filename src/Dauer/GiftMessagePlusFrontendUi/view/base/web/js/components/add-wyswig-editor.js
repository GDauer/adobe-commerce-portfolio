/**
 * @authro Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
define([
    'jquery',
    'giftPlusConfigProvide',
    'mage/adminhtml/wysiwyg/tiny_mce/setup',
    'mage/translate'
], function ($, configProvider, wysiwygSetup, $t) {
    'use strict';

    const bypassKey = ["Backspace", "MetaLeft", "ControlLeft", "ArrowLeft", "ArrowRight", "ArrowDown", "ArrowUp"];
    let config = {
        tinymce: {
            css_selector: configProvider.cssSelector(),
            plugins: configProvider.plugins()
        }
    };

    /**
     * function to initialize wysiwyg editor.
     *
     * @param {Object} {index: String}
     */
    return function (data) {
        config.tinymce = {...config.tinymce, ...configProvider.additionalSettings()};

        if (!configProvider.enabled()) {
            return;
        }

        if (data.area === 'frontend') {
            config.tinymce.css_selector = configProvider.cssSelector() + data.index;
        } else {
            config.tinymce.css_selector = data.index;
        }

        wysiwygSetup.prototype.initialize(config.tinymce.css_selector, config);
        wysiwygSetup.prototype.setup(configProvider.mode());
        addMaxLengthValidationToTinyMCEEditor(config.tinymce.css_selector);
        addMaxLengthValidationForPasteCommand(config.tinymce.css_selector);
    };

    /**
     * Add max length validation.
     *
     * @param {String} editorId
     */
    function addMaxLengthValidationToTinyMCEEditor(editorId) {
        let editor = tinymce.get(editorId);
        if (!editor) {
            return;
        }

        editor.on('keydown', function (e) {
            let contents = editor.getContent({ format: 'text' });
            if (contents.length < configProvider.maxLength() || !e.isTrusted || bypassKey.includes(e.code)) {
                return;
            }

            e.preventDefault();
            editor.notificationManager.open({
                text: $t('Maximum of %1 characters allowed!').replace('%1', configProvider.maxLength()),
                type: 'warning',
                timeout: 2000
            });
        });
    }

    /**
     * Add max length to copy and paste.
     *
     * @param {String} editorId
     */
    function addMaxLengthValidationForPasteCommand(editorId) {
        let editor = tinymce.get(editorId);

        editor.on('paste', function (e) {
            let content = editor.getContent({ format: 'text' });
            let pasted = (e.clipboardData || window.clipboardData).getData('text');

            if (content.length + pasted.length < configProvider.maxLength()) {
                return;
            }

            e.preventDefault();
            editor.notificationManager.open({
                text: $t('Maximum of %1 characters allowed!').replace('%1', configProvider.maxLength()),
                type: 'warning',
                timeout: 2000
            });
        });
    }
});
