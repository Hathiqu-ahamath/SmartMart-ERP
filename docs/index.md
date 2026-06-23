# SmartMart ERP System

> A comprehensive Enterprise Resource Planning system for retail and wholesale businesses built with Laravel 11.

## Table of Contents

1. [Overview](#overview)
2. [Technologies Used](#technologies-used)
3. [System Requirements](#system-requirements)
4. [Installation & Setup](#installation--setup)
5. [System Architecture](architecture.md)
6. [Directory Structure](structure.md)
7. [Database Schema](database.md)
8. [Modules & Features](modules.md)
9. [API Endpoints](api.md)
10. [User Roles & Permissions](roles.md)
11. [Troubleshooting](troubleshooting.md)

---

## Overview

SmartMart ERP is a web-based management system designed to streamline retail/wholesale operations. It provides end-to-end inventory tracking, purchase order management, goods receipt, point-of-sale (POS), sales reporting, and user administration.

### Key Capabilities

- **Inventory Management** — Track stock levels, movements, adjustments, low-stock alerts, expiry tracking
- **Purchasing** — Create, approve, cancel purchase orders; manage suppliers
- **Goods Receipt (GRN)** — Receive purchase order items, auto-update inventory
- **Point of Sale (POS)** — Billing interface with cart, customer info, tax/discount, receipts
- **Reporting** — Daily/monthly sales, profit calculations, inventory reports
- **User Management** — Role-based access control (RBAC) with admin, manager, cashier, storekeeper roles

---

## Technologies Used

### Backend
| Technology | Version | Purpose |
|------------|---------|---------|
| PHP | 8.1+ | Server-side scripting language |
| Laravel | 11.x | MVC framework |
| MySQL | 8.0+ | Relational database |
| Laravel Sanctum | — | API token authentication |

### Frontend
| Technology | Version | Purpose |
|------------|---------|---------|
| Blade | — | Laravel templating engine |
| Bootstrap | 5.3.2 | CSS framework (UI components) |
| Bootstrap Icons | 1.11.1 | Icon library |
| Font Awesome | 6.4.2 | Additional icons |
| Chart.js | 4.x | Interactive charts (dashboard/reports) |
| jQuery | 3.7.1 | DOM manipulation (POS, GRN) |
| Vanilla JavaScript | — | AJAX calls, dynamic forms |

### Development Tools
| Tool | Purpose |
|------|---------|
| Composer | PHP dependency management |
| Artisan | Laravel CLI for migrations, seeding, caching |
| Git | Version control |
| XAMPP | Local development environment (Apache + MySQL + PHP) |

---

## System Requirements

| Requirement | Minimum |
|-------------|---------|
| PHP | 8.1 or higher |
| Composer | 2.x |
| Database | MySQL 8.0+ / MariaDB 10.3+ |
| Web Server | Apache 2.4+ / Nginx 1.18+ |
| Memory | 256 MB (PHP memory_limit) |
| Storage | 100 MB for application files |
| Browser | Chrome 90+, Firefox 88+, Edge 90+ |

---

## Installation & Setup

### 1. Prerequisites

Ensure you have installed:
- PHP 8.1+ with extensions: `BCMath`, `Ctype`, `Fileinfo`, `JSON`, `Mbstring`, `OpenSSL`, `PDO`, `Tokenizer`, `XML`, `MySQL`
- Composer ([getcomposer.org](https://getcomposer.org))
- MySQL 8.0+ database server
- A web server (Apache or Nginx)

### 2. Clone / Copy the Project

```bash
cd C:\xampp\htdocs
# Copy the project folder to your web server directory
```

### 3. Install PHP Dependencies

```bash
cd SmartMart\ ERP
composer install
```

### 4. Environment Configuration

```bash
# Copy the example environment file
copy .env.example .env
# Or on Linux: cp .env.example .env
```

Edit `.env` and set your database credentials:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartmart_erp
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create Database

```sql
CREATE DATABASE smartmart_erp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Or via Laravel:

```bash
php artisan db:create  # If using a package that provides this
```

### 7. Run Migrations & Seeders

```bash
php artisan migrate --seed
```

This creates all tables and populates them with:
- Default admin user
- Sample roles (admin, manager, cashier, storekeeper)
- Sample categories, products, suppliers (50+ records)
- Sample sales and purchase orders with transaction data
- Stock movements history

### 8. Storage Link (for file uploads)

```bash
php artisan storage:link
```

### 9. Start Development Server

```bash
php artisan serve
# Access at http://127.0.0.1:8000
```

### 10. Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@smartmart.com | password |
| Manager | manager@smartmart.com | password |
| Cashier | cashier@smartmart.com | password |
| Storekeeper | storekeeper@smartmart.com | password |

---

## Quick Start

1. Start the server: `php artisan serve`
2. Open `http://127.0.0.1:8000` in your browser
3. Login with `admin@smartmart.com` / `password`
4. From the Dashboard, navigate through:
   - **Products** → View/add products
   - **Suppliers** → Manage suppliers
   - **Purchase Orders** → Create and approve POs
   - **Goods Receipt** → Receive ordered stock
   - **POS Billing** → Process sales
   - **Reports** → View daily/monthly/inventory reports
   - **Users/Roles** → Manage access (admin only)
