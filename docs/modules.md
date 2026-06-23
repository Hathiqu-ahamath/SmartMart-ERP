# Modules & Features

## 1. Authentication (`/login`)

| Feature | Details |
|---------|---------|
| Login | Email + password authentication |
| Role-based redirect | Redirects to appropriate page based on role after login |
| Session management | Laravel session with remember-me |
| Logout | Session invalidation + token regeneration |

Controllers: `LoginController`
Views: `auth.login`
Route: `GET|POST /login`, `POST /logout`

---

## 2. Dashboard (`/dashboard`)

| Feature | Details |
|---------|---------|
| Stat cards | Total products, low stock items, pending POs, today's sales |
| Charts | Daily sales trend (7-day) via Chart.js, product category distribution |
| Quick links | Recent sales, low stock alerts, expiring products |
| Data source | Aggregated from Product, PurchaseOrder, Sale models |

Controllers: `DashboardController`
Views: `dashboard.index`
Route: `GET /dashboard`

---

## 3. User Management (`/users`)

| Feature | Details |
|---------|---------|
| List | Paginated table with search |
| Create | Form with name, email, password, role selection |
| Edit | Update user details and role |
| Show | View user details |
| Delete | Remove user |
| Access | Admin only (`role:admin` middleware) |

Controllers: `UserController`
Views: `users.{index,create,edit,show}`
Route: `Route::resource('users')`

---

## 4. Role Management (`/roles`)

| Feature | Details |
|---------|---------|
| List | All roles with assigned user count |
| Create | Name, slug, description |
| Edit | Update role details |
| Delete | Remove role (with guard) |
| Access | Admin only (`role:admin` middleware) |

Controllers: `RoleController`
Views: `roles.{index,create,edit,show}`
Route: `Route::resource('roles')`

---

## 5. Categories (`/categories`)

| Feature | Details |
|---------|---------|
| List | Categories with product count |
| Create | Name + description |
| Edit | Update name/description |
| Show | Category details + products in category |
| Delete | Remove category |
| Slug | Auto-generated from name |

Controllers: `CategoryController` + `CategoryService`
Views: `categories.{index,create,edit,show}`
Route: `Route::resource('categories')`

---

## 6. Products (`/products`)

| Feature | Details |
|---------|---------|
| List | Paginated, searchable by name/code/barcode |
| Create | Full form with validation, unique constraints |
| Edit | Update product details |
| Show | Product info + recent stock movements |
| Delete | Soft delete |
| Filters | Category filter |
| Low stock badge | Sidebar badge for low-stock alerts |

Controllers: `ProductController` + `ProductService` + `ProductRepository`
Views: `products.{index,create,edit,show}`
Route: `Route::resource('products')`

---

## 7. Suppliers (`/suppliers`)

| Feature | Details |
|---------|---------|
| List | Paginated supplier table |
| Create | Company info, contact details |
| Edit | Update supplier |
| Show | Supplier details |
| Delete | Remove supplier |

Controllers: `SupplierController` + `SupplierService`
Views: `suppliers.{index,create,edit,show}`
Route: `Route::resource('suppliers')`

---

## 8. Purchase Orders (`/purchases`)

| Feature | Details |
|---------|---------|
| List | Paginated PO list with status badges |
| Create | Select supplier, add products with qty/price (dynamic rows) |
| Show | PO detail with items, approve/cancel actions |
| Approve | Status: draft → pending → approved |
| Cancel | Cancel PO (no stock impact) |
| Auto-numbering | PO-YYYYMMDD-XXXXXX format |

Controllers: `PurchaseOrderController` + `PurchaseOrderService`
Views: `purchases.{index,create,show}`
Route: `purchases.*`

**Status Flow:**
```
draft → pending → approved → received
                    ↘ cancelled
```

---

## 9. Goods Received Note (`/grn`)

| Feature | Details |
|---------|---------|
| List | GRN list with supplier info |
| Create | Select PO → AJAX loads PO items → enter received quantities |
| Auto-stock update | Received qty increments product stock |
| Partial receiving | POs can be partially received; status tracks remaining |
| Show | GRN detail with received items |

Controllers: `GrnController` + `GrnService`
Views: `grn.{index,create,show}`
Route: `grn.*`

**Key Logic:**
- Only `approved` POs are shown (fully-received POs excluded)
- On receipt, PO items' `received_quantity` increments
- If all items fully received, PO status → `received`
- GRN status → `fully_received` or `partially_received`
- StockMovement created with `type='purchase'`, `reference_type='GRN'`

---

## 10. Inventory / Stock (`/inventory`)

| Feature | Details |
|---------|---------|
| List | Stock levels with filters (all, low stock, expired, expiring) |
| Stock value | Total inventory value (qty × cost_price) |
| Movements | Full audit trail of all stock changes |
| Adjust | Manual stock adjustment (+/-) with reason |

Controllers: `InventoryController` + `ProductService`
Views: `inventory.{index,movements,adjust}`
Route: `inventory.*`

---

## 11. Sales / POS (`/sales`)

| Feature | Details |
|---------|---------|
| POS Billing | Product grid, cart, customer info, tax/discount, checkout |
| Cart management | Add/remove items, quantity change |
| Auto-calculation | Subtotal, tax, discount, grand total |
| Payment methods | Cash, card, transfer |
| Invoice number | Auto-generated (INV-YYYYMMDD-XXXXXX) |
| Stock deduction | Real-time quantity decrement on sale |
| Sales history | Paginated list with filters |
| Receipt | Printable receipt view |
| Profit tracking | Cost price stored in sale_items for profit reporting |

Controllers: `SaleController` + `SaleService`
Views: `sales.{index,pos,show,receipt}`
Route: `sales.*`

---

## 12. Reports (`/reports`)

### Daily Sales
| Feature | Details |
|---------|---------|
| Date picker | Select any date |
| Metrics | Total sales, transaction count, total profit |
| Sales list | All sales for the selected date |
| Profit formula | Σ((unit_price - cost_price) × quantity) |

### Monthly Sales
| Feature | Details |
|---------|---------|
| Month/year picker | Select month and year |
| Metrics | Revenue, transactions, profit |
| Daily breakdown | Chart-ready daily revenue data |
| Trend data | Day-by-day sales progression |

### Inventory Report
| Feature | Details |
|---------|---------|
| Overview | Total products, low stock, expired, expiring counts |
| Total value | Aggregate stock value |
| Category breakdown | Product count, total qty, total value per category |

Controllers: `ReportController`
Views: `reports.{daily,monthly,inventory}`
Route: `reports.*`
