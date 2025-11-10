# Dauer_GiftMessagePlusApi Module

The **Dauer_GiftMessagePlusApi** module is a core component of the **Gift Message Plus** feature set.  
It defines all **API contracts** required by the main `Dauer_GiftMessagePlus` module and ensures a clean separation between service definitions and business logic.

---

## 🧩 Overview

This module provides the **service contracts (interfaces)** used by the Gift Message Plus feature.  
It defines the public API layer, ensuring that other modules or integrations can interact with the Gift Message Plus functionality in a consistent and decoupled way.

---

## 🎯 Module Purpose

- Define API interfaces and data models for the Gift Message Plus feature.
- Provide a stable and versioned contract layer for implementations in other modules.
- Maintain modular architecture and separation of concerns following Magento 2 best practices.

---

## ⚙️ Installation

For detailed information about module installation in Magento 2, refer to the official Magento DevDocs:

🔗 [Enable or disable modules](https://devdocs.magento.com/guides/v2.4/install-gde/install/cli/install-cli-subcommands-enable.html)

### Quick installation steps

1. Copy the module to `app/code/Dauer/GiftMessagePlusApi`.
2. Run the following CLI commands:
```bash
   bin/magento module:enable Dauer_GiftMessagePlusApi
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
After installation:
- Ensure that the API interfaces defined by this module are available under the Magento service layer.
- Verify that dependent modules (like Dauer_GiftMessagePlus) function correctly and can reference these contracts.

---


## 🧑‍💻 Author
- Gustavo Dauer (gustavo.dauer@hotmail.com)
- My Linkedin: https://www.linkedin.com/in/gustavo-vicente-dauer/?locale=en_US
