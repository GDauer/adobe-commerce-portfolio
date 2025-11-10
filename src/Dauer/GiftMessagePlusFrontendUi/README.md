# Dauer_GiftMessagePlusFrontendUi Module

The **Dauer_GiftMessagePlusFrontendUi** module is a frontend component of the **Gift Message Plus** feature.  
It provides all frontend-related functionality required to make the main Gift Message Plus feature fully operational on the storefront.

---

## 🧩 Overview

This module handles the **frontend UI logic** for the Gift Message Plus feature.  
It includes layout updates, KnockoutJS components, templates, and other frontend enhancements to ensure a smooth and rich user experience.

---

## 🎯 Module Purpose

- Implement frontend functionality for the Gift Message Plus feature.
- Enhance the gift message UI with **WYSIWYG editor support**, dynamic behavior, and improved customer interaction.
- Ensure proper integration with Magento's checkout and product pages.

---

## ⚙️ Installation

For detailed information about module installation in Magento 2, refer to the official Magento DevDocs:

🔗 [Enable or disable modules](https://devdocs.magento.com/guides/v2.4/install-gde/install/cli/install-cli-subcommands-enable.html)

### Quick installation steps

1. Get the module using composer.
2. Run the following CLI commands:
```bash
   bin/magento module:enable Dauer_GiftMessagePlus
   bin/magento setup:upgrade
   bin/magento setup:di:compile
   bin/magento setup:static-content:deploy -f
```

---
## 🧪 Testing

After installation, verify that:
- The gift message field is visible on the storefront checkout and product pages.
- The WYSIWYG editor appears and functions correctly.
- Dynamic behaviors (e.g., character limits, live previews) work as expected.

---

## 🧱 Compatibility
- Magento Open Source / Adobe Commerce: 2.4.7+ and later
- PHP: 8.3+

---
