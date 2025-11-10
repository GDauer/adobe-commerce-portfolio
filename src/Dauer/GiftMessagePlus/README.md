# Dauer GiftMessagePlus Module

The **Dauer_GiftMessagePlus** module extends Magento's default gift message functionality by introducing new and enhanced features to improve the user experience.

This module has been created to be a portfolio of my knowledges on Adobe Commerce.

This module shows:
- Knowledge on frontend architecture and customization
  - Layout customization
  - Javascript components
  - KnockoutJS
  - Checkout/Cart customizations
  - MVVM architecture
- Custom configurations System.xml
- Dependency injection (DI) knowledge

---

## 🧩 Overview

This module enhances the **Gift Message** feature in Magento 2 by adding a **WYSIWYG editor** to the message input area, allowing richer and more flexible message formatting for customers and administrators.

---

## 🎯 Module Purpose

- Improve the usability of the gift message component.
- Enable WYSIWYG editing for gift messages on both the frontend and admin.
- Provide a better presentation and customization experience for end users.

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

## 🧱 Compatibility
- Magento Open Source / Adobe Commerce: 2.4.7+ and later
- PHP: 8.3+

---

## 🧪 Testing
After installation, verify that:
- The new admin area appears under Stores → Configuration → Sales
- The Gift Message field is visible and functional.
- The WYSIWYG editor appears as expected.
- Gift messages are saved and displayed correctly in both frontend and email areas.

---

## 🧑‍💻 Author
- Gustavo Dauer (gustavo.dauer@hotmail.com)
- My Linkedin: https://www.linkedin.com/in/gustavo-vicente-dauer/?locale=en_US
