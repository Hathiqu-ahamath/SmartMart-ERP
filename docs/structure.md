# Directory Structure

```
SmartMart ERP/
│
├── app/
│   ├── Console/
│   │   └── Commands/                 # Custom Artisan commands
│   │       └── GenerateReports.php
│   │
│   ├── Exceptions/
│   │   └── Handler.php               # Global exception handler
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php       # Authentication
│   │   │   ├── Api/
│   │   │   │   ├── ProductApiController.php   # REST API for products
│   │   │   │   └── ReportApiController.php    # REST API for reports
│   │   │   ├── CategoryController.php         # CRUD categories
│   │   │   ├── DashboardController.php        # Dashboard stats/charts
│   │   │   ├── GrnController.php              # Goods Received Notes
│   │   │   ├── InventoryController.php        # Stock view/adjustments
│   │   │   ├── ProductController.php          # CRUD products
│   │   │   ├── PurchaseOrderController.php    # PO management
│   │   │   ├── ReportController.php           # Reports (daily, monthly, inventory)
│   │   │   ├── RoleController.php             # CRUD roles
│   │   │   ├── SaleController.php             # POS + sales history
│   │   │   ├── SupplierController.php         # CRUD suppliers
│   │   │   └── UserController.php             # CRUD users
│   │   │
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php             # Role-based access filter
│   │   │
│   │   └── Requests/                  # Form request validation (unused, inline validation used)
│   │
│   ├── Models/
│   │   ├── Category.php               # Product categories
│   │   ├── Grn.php                    # Goods Received Note header
│   │   ├── GrnItem.php                # GRN line items
│   │   ├── Product.php                # Products (with SoftDeletes)
│   │   ├── PurchaseOrder.php          # PO header
│   │   ├── PurchaseOrderItem.php      # PO line items
│   │   ├── Role.php                   # User roles
│   │   ├── Sale.php                   # Sales/invoices
│   │   ├── SaleItem.php               # Sale line items
│   │   ├── StockMovement.php          # Stock movement audit trail
│   │   ├── Supplier.php               # Suppliers
│   │   └── User.php                   # Users (extends Authenticatable)
│   │
│   ├── Providers/
│   │   └── AppServiceProvider.php      # App bootstrap
│   │
│   ├── Repositories/
│   │   └── ProductRepository.php       # Product-specific DB queries
│   │
│   └── Services/
│       ├── CategoryService.php         # Category business logic
│       ├── GrnService.php              # GRN business logic
│       ├── ProductService.php          # Product business logic
│       ├── PurchaseOrderService.php    # PO business logic
│       ├── SaleService.php             # Sales business logic
│       └── SupplierService.php         # Supplier business logic
│
├── bootstrap/                          # Laravel bootstrap files
│
├── config/
│   ├── app.php                         # App configuration
│   ├── auth.php                        # Auth guards/providers
│   ├── cache.php, database.php, etc.   # Framework configuration
│   ├── sanctum.php                     # API token configuration
│   └── session.php                     # Session driver config
│
├── database/
│   ├── factories/                      # Model factories (seeding)
│   ├── migrations/
│   │   ├── 0001_create_cache_table.php
│   │   ├── 0002_create_roles_table.php
│   │   ├── 0003_create_users_table.php
│   │   ├── 0004_create_categories_table.php
│   │   ├── 0005_create_products_table.php
│   │   ├── 0006_create_suppliers_table.php
│   │   ├── 0007_create_purchase_orders_table.php
│   │   ├── 0008_create_purchase_order_items_table.php
│   │   ├── 0009_create_grns_table.php
│   │   ├── 0010_create_grn_items_table.php
│   │   ├── 0011_create_stock_movements_table.php
│   │   ├── 0012_create_sales_table.php
│   │   └── 0013_create_sale_items_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php          # Master seeder
│       ├── RoleSeeder.php              # 4 roles
│       ├── UserSeeder.php              # 4 users (one per role)
│       ├── CategorySeeder.php          # 10 categories
│       ├── ProductSeeder.php           # 60 products
│       ├── SupplierSeeder.php          # 15 suppliers
│       ├── PurchaseOrderSeeder.php     # 20 POs with items
│       ├── GrnSeeder.php               # 10 GRNs
│       ├── SaleSeeder.php              # 50 sales with items
│       └── StockMovementSeeder.php     # Stock movement history
│
├── docs/                               # Documentation (this folder)
│
├── public/
│   ├── index.php                       # Front controller
│   └── storage/                        # Symlinked to storage/app/public
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php           # Main layout (head, sidebar, content)
│       │   └── sidebar.blade.php       # Navigation sidebar
│       ├── auth/
│       │   └── login.blade.php         # Login page
│       ├── users/
│       │   ├── index.blade.php         # User list (admin CRUD)
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── roles/
│       │   ├── index.blade.php         # Role management
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── categories/
│       │   ├── index.blade.php         # Category list
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── products/
│       │   ├── index.blade.php         # Product list (searchable)
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php          # Product detail + stock movements
│       ├── suppliers/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── purchases/
│       │   ├── index.blade.php         # PO list with filters
│       │   ├── create.blade.php        # PO creation with dynamic items
│       │   └── show.blade.php          # PO detail + approve/cancel
│       ├── grn/
│       │   ├── index.blade.php         # GRN list
│       │   ├── create.blade.php        # GRN with PO item loading (AJAX)
│       │   └── show.blade.php          # GRN detail
│       ├── inventory/
│       │   ├── index.blade.php         # Stock levels + filters
│       │   ├── movements.blade.php     # Stock movement history
│       │   └── adjust.blade.php        # Stock adjustment form
│       ├── sales/
│       │   ├── index.blade.php         # Sales history
│       │   ├── pos.blade.php           # POS interface
│       │   ├── show.blade.php          # Sale detail
│       │   └── receipt.blade.php       # Printable receipt
│       └── reports/
│           ├── daily.blade.php         # Daily sales report
│           ├── monthly.blade.php       # Monthly sales report
│           └── inventory.blade.php     # Inventory status report
│
├── routes/
│   ├── web.php                         # Web routes (auth + all modules)
│   ├── api.php                         # API routes (Sanctum-protected)
│   └── console.php                     # Artisan command routes
│
├── storage/                            # Logs, cache, compiled views
│
├── .env.example                        # Environment template
├── artisan                             # Laravel CLI entry point
├── composer.json                       # PHP dependencies
├── package.json                        # Optional Node dependencies
└── README.md                           # Quick-start guide
```
