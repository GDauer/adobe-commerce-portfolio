<p align="center">
  <img src="https://devfan.co.uk/wp-content/uploads/2025/05/Adobe-Commerce-icon.png" alt="Adobe Commerce Logo" width="180"/>
</p>

<h1 align="center">Adobe Commerce Portfolio</h1>
<p align="center">
  <a href="https://business.adobe.com/products/magento/magento-commerce.html">
    <img src="https://img.shields.io/badge/Adobe_Commerce-2.4.8-CC0000.svg?logo=adobe&logoColor=white" alt="Adobe Commerce Version"/>
  </a>
  <a href="https://www.php.net/">
    <img src="https://img.shields.io/badge/PHP-8.3-blue.svg" alt="PHP Version"/>
  </a>
  <a href="https://mariadb.org/">
    <img src="https://img.shields.io/badge/MariaDB-11.4-green.svg" alt="MariaDB Version"/>
  </a>
  <a href="https://www.rabbitmq.com/">
    <img src="https://img.shields.io/badge/RabbitMQ-4.1-orange.svg" alt="RabbitMQ Version"/>
  </a>
  <a href="#-test-coverage">
    <img src="https://img.shields.io/badge/Test_Coverage-100%25-brightgreen.svg" alt="Test Coverage"/>
  </a>
</p>

## 📚 Table of Contents
- [📘 Project Overview](#-project-overview)
- [🧱 Tech Stack](#-tech-stack)
- [✨ Features](#-features)
  - [🏷️ Gift Message Plus](#-gift-message-plus)
  - [📨 Review Reminder](#-review-reminder)
- [🧠 Learning Objectives](#-learning-objectives)
- [⚙️ Setup & Installation](#-setup--installation)
- [💻 Example Use Cases](#-example-use-cases)
- [🧪 Test Coverage](#-test-coverage)
  - [⚙️ Running Tests](#-running-tests)
  - [📊 Test Coverage Report](#-test-coverage-report)
  - [📑 Test Suites](#-test-suites)
- [🤝 Contributing](#-contributing)
- [👤 Author](#-author)
- [🧾 License](#-license)
- [🏁 Future Improvements](#-future-improvements)

## 📘 Project Overview

This repository contains a **portfolio project** built to demonstrate my technical knowledge and capabilities in **Adobe Commerce (Magento 2)** development.  
The project includes two custom features developed entirely from scratch, covering both **frontend** and **backend** aspects of the platform.

## 🧱 Tech Stack

- **Adobe Commerce / Magento 2**
- **PHP 8.3**
- **MariaDB 11.4**
- **RabbitMQ 4.1**
- **KnockoutJS**
- **RequireJS**
- **TinyMCE**
- **Magento Queue and Cron Framework**
- **PHPUnit 10.x** (Testing Framework)

## ✨ Features

### 🏷️ Gift Message Plus

An enhancement of the native *Gift Message* functionality, improving the user experience with a WYSIWYG editor and dynamic frontend behavior.

**Key Highlights**
- Added **WYSIWYG editor** for rich-text gift messages.
- Customized **checkout UI** components using **KnockoutJS** and **UI Components**.
- Demonstrated knowledge of **system configuration** for enabling/disabling features.
- Showcased **frontend customization** with XML, JS mixins, and templates.

**Skills demonstrated**
- 🧠 Frontend customization
- 🛒 Checkout customization
- ⚙️ KnockoutJS component extension
- 🧩 System configuration
- 💅 UI/UX enhancement

### 📨 Review Reminder

A complete backend feature that automatically sends reminder emails to customers asking them to review purchased products.  
The system supports filtering by **customer group**, **specific SKUs**, and **date ranges**, with asynchronous processing through RabbitMQ.

**Key Highlights**
- Created **custom database table** for review campaign definitions.
- Developed **admin forms and grids** to manage campaign data.
- Implemented **cron jobs** to schedule reminders.
- Integrated **RabbitMQ queues** for async message handling.
- Customized **email templates** for notifications.

**Skills demonstrated**
- 🧩 Backend architecture
- 🧾 Models and Resource Models
- 🧰 Controllers and Repositories
- 📨 Queue creation and consumer handling
- 🕒 Cron jobs and asynchronous processes
- 💌 Email customization

## 🧠 Learning Objectives

This project was built as a **hands-on showcase** of my full-stack Adobe Commerce knowledge, demonstrating:
- Strong understanding of the **Magento framework architecture**
- Ability to build **scalable custom features**
- Experience integrating **asynchronous and event-driven logic**
- Proficiency in **frontend (UI Components, Knockout, RequireJS)** and **backend (models, observers, queues, crons)** development

## ⚙️ Setup & Installation

> ⚠️ This repository is for demonstration purposes only and not intended for production.

1. Clone the repository:
```bash
   git clone https://github.com/GDauer/adobe-commerce-portfolio.git
```
2. Add the src modules to app/code ou vendor using composer
3. run deployment process

## 💻 Example Use Cases
This portfolio project can serve multiple practical purposes:
- 🎓 **Technical Demonstration:** Showcase my Adobe Commerce (Magento 2) development skills for interviews and professional evaluations.
- 🧱 **Reference Implementation:** Use it as a starting point for building or structuring my own Adobe Commerce's custom modules.
- 🧠 **Learning Resource:** Understand key architectural patterns in Adobe Commerce's backend and frontend development.
- ⚙️ **Best Practices Example:** Illustrates clean code organization, dependency injection, asynchronous processing, and UI customization.

## 🧪 Test Coverage
This project maintains **100% unit test coverage** for critical backend components using **PHPUnit**.

### ⚙️ Running Tests
```bash
XDEBUG_MODE=coverage ./vendor/bin/phpunit -c dev/tests/unit/phpunit.xml.dist
```

### 📊 Test Coverage Report
| Component         | Coverage | Status |
|-------------------| --- | --- |
| `ReviewReminder`  | 100% | ✅ |
| `GiftMessagePlus` | 100% | ✅ |
| **Overall**       | **100%** | **✅** |

### 📑 Test Suites
- **Unit Tests:** Core business logic and command handlers
- **Integration Tests:** Interaction with Magento framework components

## 🤝 Contributing
Contributions, feedback, and suggestions are always welcome!
If you'd like to contribute:
1. **Fork** the repository.
2. Create a new feature branch:
```bash
git checkout -b feature/your-feature-name
git commit -S -m "feature: your feature description"
git push origin feature/your-feature-name
```

## 👤 Author
**Gustavo Dauer**
* 💼 _Adobe Commerce Developer_
* 📧 [gustavo.dauer@hotmail.com](mailto:gustavo.dauer@hotmail.com)
* 🌐 [LinkedIn](https://www.linkedin.com/in/gustavo-vicente-dauer/?locale=en_US)

## 🧾 License
This project is open-sourced and provided for educational and portfolio purposes only.
All **Adobe Commerce** trademarks are the property of **Adobe Inc.**

## 🏁 Future Improvements
Planned enhancements for future updates:
- 🧪 Add automated tests (unit and integration) using PHPUnit ✅ _In Progress_
- 🐳 Includes a Docker environment for simplified setup
- 🖼️ Add screenshots or UI previews for better visual context
- 📘 Add architecture diagrams to illustrate system flow
- 🌐 Create monorepo structure for each feature
- 🔐 New Backlog for new features

> _Built with passion for clean, scalable, and well-structured Adobe Commerce solutions._
