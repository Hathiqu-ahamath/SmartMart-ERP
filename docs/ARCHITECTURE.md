# System Architecture

## Architecture Overview

SmartMart ERP follows the **Laravel MVC (Model-View-Controller)** architecture with a **Service Layer** pattern for business logic separation.

```
┌─────────────────────────────────────────────────────────────┐
│                    Presentation Layer                        │
│  Blade Templates (views/)  +  Bootstrap 5  +  Chart.js      │
│                    JavaScript (AJAX)                         │
├─────────────────────────────────────────────────────────────┤
│                    HTTP Layer                                │
│  Routes (web.php, api.php)  →  Middleware (auth, role)      │
│                    Controllers                               │
├─────────────────────────────────────────────────────────────┤
│                    Business Logic Layer                      │
│              Services (Services/)                            │
│      Encapsulates all domain operations                     │
├─────────────────────────────────────────────────────────────┤
│                    Data Access Layer                         │
│  Models (Eloquent ORM)  +  Repositories (Repositories/)     │
│                    Database (MySQL)                          │
└─────────────────────────────────────────────────────────────┘
```

## Request Lifecycle

```
Browser Request
       │
       ▼
   Web Server (Apache/Nginx)
       │
       ▼
   index.php (Front Controller)
       │
       ▼
   Kernel (HTTP)
       │
       ▼
   Router (routes/web.php)
       │
       ▼
   Middleware Stack
       ├─ Guest/Auth Middleware (authentication check)
       ├─ Role Middleware (authorization check)
       │
       ▼
   Controller
       │
       ▼
   Service Layer (business logic, transactions)
       │
       ▼
   Model / Repository (database queries via Eloquent)
       │
       ▼
   Blade View (response rendering)
       │
       ▼
   Browser Response (HTML + assets)
```

## Architectural Decisions

| Decision | Rationale |
|----------|-----------|
| **Service Layer** | Keeps controllers thin; reusable business logic across controllers/commands/API |
| **Repository Pattern** (ProductRepository) | Encapsulates complex queries; easier testing; single source of truth for Product queries |
| **Soft Deletes** on Products | Prevents accidental data loss; maintains referential integrity for historical sales/POS |
| **CSRF Protection** | All POST/PUT/DELETE forms include CSRF tokens for security |
| **Role Middleware** | Granular access control at route level using `slug` comparison |
| **Database Transactions** | Critical operations (sales, GRN, purchases) wrapped in `DB::transaction()` for atomicity |

## Naming Conventions

| Component | Convention | Example |
|-----------|------------|---------|
| Controllers | `{Name}Controller` | `ProductController`, `SaleController` |
| Services | `{Name}Service` | `ProductService`, `SaleService` |
| Models | Single, StudlyCase | `Product`, `PurchaseOrder`, `SaleItem` |
| Migrations | `YYYY_MM_DD_HHMMSS_create_{table}_table` | `2024_01_01_000001_create_products_table` |
| Routes | `{module}.{action}` | `products.index`, `sales.pos` |
| Views | `{module}.{action}` | `products.index`, `sales.pos` |
| Tables | snake_case, plural | `purchase_orders`, `stock_movements` |
