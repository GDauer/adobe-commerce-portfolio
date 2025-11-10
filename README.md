# 🧩 Adobe Commerce Portfolio

[![PHP Version](https://img.shields.io/badge/PHP-8.3-blue.svg)](https://www.php.net/)
[![MariaDB Version](https://img.shields.io/badge/MariaDB-11.4-green.svg)](https://mariadb.org/)
[![RabbitMQ Version](https://img.shields.io/badge/RabbitMQ-4.1-orange.svg)](https://www.rabbitmq.com/)

---

## 📘 Project Overview

This repository contains a **portfolio project** built to demonstrate my technical knowledge and capabilities in **Adobe Commerce (Magento 2)** development.  
The project includes two custom features developed entirely from scratch, covering both **frontend** and **backend** aspects of the platform.

---

## 🧱 Tech Stack

- **Adobe Commerce / Magento 2**
- **PHP 8.3**
- **MariaDB 11.4**
- **RabbitMQ 4.1**
- **KnockoutJS**
- **RequireJS**
- **TinyMCE**
- **Magento Queue and Cron Framework**

---

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

---

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

---

## 🧠 Learning Objectives

This project was built as a **hands-on showcase** of my full-stack Adobe Commerce knowledge, demonstrating:
- Strong understanding of the **Magento framework architecture**
- Ability to build **scalable custom features**
- Experience integrating **asynchronous and event-driven logic**
- Proficiency in **frontend (UI Components, Knockout, RequireJS)** and **backend (models, observers, queues, crons)** development

---

## ⚙️ Setup & Installation

> ⚠️ This repository is for demonstration purposes only and not intended for production.

1. Clone the repository:
```bash
   git clone https://github.com/GDauer/adobe-commerce-portfolio.git
````
2. Add the src modules to app/code ou vendor using composer
3. run deployment process

---

## 👤 Author
Gustavo Dauer (gustavo.dauer@hotmail.com)
- 💼 Adobe Commerce Developer
- 🌐 Linkedin: https://www.linkedin.com/in/gustavo-vicente-dauer/?locale=en_US

---
## 🧾 License

This project is open-sourced and provided for educational and portfolio purposes.
All Adobe Commerce trademarks are property of Adobe Inc.