# SmartMart ERP

A Laravel 11 retail/wholesale ERP system with inventory management, purchasing, POS billing, goods receiving (GRN), reporting, and user role management.

## Requirements

- PHP 8.1+
- MySQL 8 or MariaDB
- Composer

**Required PHP extensions:** `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `pdo_mysql`, `xml`, `gd`

---

## Installation

### Method 1: Quick (Import SQL via phpMyAdmin)

1. **Create the database**
   - Open phpMyAdmin → New → Database name: `smartmart_erp` → Create

2. **Import the database**
   - Click the `smartmart_erp` database → Import tab
   - Click Choose File → select `database/smartmart_erp.sql` → Go

3. **Setup the project**
   ```bash
   cd "SmartMart ERP"
   copy .env.example .env
   ```
   Edit `.env` — set your database credentials:
   ```
   DB_DATABASE=smartmart_erp
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   ```bash
   composer install
   php artisan key:generate
   php artisan serve
   ```

4. Open `http://127.0.0.1:8000`

---

### Method 2: Fresh Setup (Recommended)

1. **Create the database**
   - Open phpMyAdmin → New → Database name: `smartmart_erp` → Create

2. **Setup the project**
   ```bash
   cd "SmartMart ERP"
   copy .env.example .env
   php artisan key:generate
   php artisan storage:link
   ```

3. **Edit `.env` file** — set your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=smartmart_erp
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Run migrations & seeders** (creates all tables + sample data):
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Start the server**:
   ```bash
   php artisan serve
   ```

6. Open `http://127.0.0.1:8000`

---

## Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@smartmart.com` | `password` |

---

## Features

- **Dashboard** — KPIs, charts, quick stats
- **Products** — CRUD with categories, barcode, stock tracking
- **Categories** — Product categorization
- **Suppliers** — Supplier management
- **Purchase Orders** — Create, approve, cancel
- **GRN (Goods Received Note)** — Receive PO items, auto-update inventory
- **Inventory** — Stock view, movements log, stock adjustments
- **POS Billing** — Product search, cart, sale completion, receipt
- **Sales** — Sale history with details
- **Reports** — Daily, monthly, inventory reports
- **User Management** — Users, roles, permissions
- **Profile** — Edit profile, change password, upload profile picture

## Roles & Access

| Role | Access |
|------|--------|
| **Admin** | Full system access |
| **Manager** | View reports, approve orders, manage products/suppliers |
| **Cashier** | POS billing, view sales |
| **Storekeeper** | Inventory, GRN, purchase orders |

## Tech Stack

- Laravel 11 / PHP 8.1+
- MySQL 8
- Bootstrap 5.3
- Fira Sans / Fira Code typography
- Chart.js
- Font Awesome / Bootstrap Icons
