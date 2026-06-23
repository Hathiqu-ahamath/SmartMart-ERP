# Database Schema

## Entity Relationship Overview

```
roles (1) ──── (N) users
                    │
                    │ hasMany
                    ▼
categories (1) ── (N) products (1) ── (N) purchase_order_items (N) ── (1) purchase_orders
                    │                                               │              │
                    │                                               │              │ (N) suppliers
                    │                                               │ (N) grn_items (1) grns
                    │                                               │
                    │                                               └── (N) stock_movements
                    │
                    └── (N) sale_items (N) ── (1) sales
```

## Tables

### `roles`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | Auto-increment |
| name | varchar(50) | Display name (e.g. "Administrator") |
| slug | varchar(50) UNIQUE | Code name (e.g. "admin") |
| description | text NULL | Role description |
| is_active | boolean | Soft toggle |
| timestamps | — | created_at, updated_at |

### `users`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | Auto-increment |
| role_id | bigint FK → roles.id | User role |
| name | varchar(100) | Full name |
| email | varchar(100) UNIQUE | Login email |
| password | varchar(255) | Bcrypt hashed |
| is_active | boolean | Login enabled |
| timestamps | — | created_at, updated_at |

### `categories`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | Auto-increment |
| name | varchar(100) UNIQUE | Category name |
| slug | varchar(100) UNIQUE | URL-friendly name |
| description | text NULL | Details |
| is_active | boolean | Active toggle |
| timestamps | — | created_at, updated_at |

### `products`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | Auto-increment |
| product_code | varchar(50) UNIQUE | SKU / internal code |
| product_name | varchar(200) | Product name |
| category_id | bigint FK → categories.id | Category |
| cost_price | decimal(10,2) | Unit cost |
| selling_price | decimal(10,2) | Unit selling price |
| quantity | integer | Current stock |
| expiry_date | date NULL | Expiry (perishables) |
| reorder_level | integer | Low-stock threshold |
| description | text NULL | Notes |
| barcode | varchar(100) UNIQUE NULL | Barcode / UPC |
| is_active | boolean | Active/inactive |
| deleted_at | timestamp NULL | Soft delete |
| timestamps | — | created_at, updated_at |

Indexes: `category_id`, `product_code`, `barcode`

### `suppliers`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | Auto-increment |
| supplier_code | varchar(50) UNIQUE | Internal code |
| company_name | varchar(200) | Company name |
| contact_person | varchar(100) NULL | Contact name |
| email | varchar(100) NULL | Contact email |
| phone | varchar(20) NULL | Phone number |
| address | text NULL | Physical address |
| is_active | boolean | Active toggle |
| timestamps | — | created_at, updated_at |

### `purchase_orders`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | Auto-increment |
| po_number | varchar(50) UNIQUE | Generated PO number |
| supplier_id | bigint FK → suppliers.id | Supplier |
| user_id | bigint FK → users.id | Created by |
| order_date | date | Order placement date |
| expected_date | date NULL | Expected delivery |
| status | varchar(20) | draft → pending → approved → received / cancelled |
| notes | text NULL | Internal notes |
| timestamps | — | created_at, updated_at |

### `purchase_order_items`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | Auto-increment |
| purchase_order_id | bigint FK → purchase_orders.id | Parent PO |
| product_id | bigint FK → products.id | Product |
| quantity | integer | Ordered quantity |
| received_quantity | integer (default 0) | Already received |
| unit_price | decimal(10,2) | Unit cost at order time |
| total_price | decimal(10,2) | Line total |
| timestamps | — | created_at, updated_at |

### `grns` (Goods Received Notes)
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | Auto-increment |
| grn_number | varchar(50) UNIQUE | Generated GRN number |
| purchase_order_id | bigint FK → purchase_orders.id | Source PO |
| user_id | bigint FK → users.id | Received by |
| received_date | date | Receipt date |
| status | varchar(20) | partially_received / fully_received |
| notes | text NULL | Receiving notes |
| timestamps | — | created_at, updated_at |

### `grn_items`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | Auto-increment |
| grn_id | bigint FK → grns.id | Parent GRN |
| purchase_order_item_id | bigint FK → purchase_order_items.id | Source PO item |
| product_id | bigint FK → products.id | Product |
| ordered_quantity | integer | Qty on PO |
| received_quantity | integer | Qty actually received |
| unit_price | decimal(10,2) | Unit price |
| total_price | decimal(10,2) | Line total |
| timestamps | — | created_at, updated_at |

### `stock_movements`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | Auto-increment |
| product_id | bigint FK → products.id | Product |
| user_id | bigint FK → users.id | Performed by |
| type | varchar(20) | purchase / sale / adjustment |
| quantity | integer | +/- change |
| reference_type | varchar(50) NULL | Source document type |
| reference_id | bigint NULL | Source document ID |
| notes | text NULL | Reason/description |
| timestamps | — | created_at, updated_at |

Index: `product_id`, `type`, `reference_type`

### `sales`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | Auto-increment |
| invoice_number | varchar(50) UNIQUE | Generated invoice# |
| user_id | bigint FK → users.id | Cashier |
| customer_name | varchar(200) NULL | Customer |
| customer_email | varchar(100) NULL | Customer email |
| customer_phone | varchar(20) NULL | Customer phone |
| subtotal | decimal(12,2) | Pre-tax/discount |
| tax_percentage | decimal(5,2) | Tax rate |
| tax_amount | decimal(12,2) | Calculated tax |
| discount_percentage | decimal(5,2) | Discount rate |
| discount_amount | decimal(12,2) | Calculated discount |
| grand_total | decimal(12,2) | Final total |
| payment_method | varchar(20) | cash / card / transfer |
| notes | text NULL | Sale notes |
| timestamps | — | created_at, updated_at |

### `sale_items`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | Auto-increment |
| sale_id | bigint FK → sales.id | Parent sale |
| product_id | bigint FK → products.id | Product |
| quantity | integer | Quantity sold |
| unit_price | decimal(10,2) | Selling price at sale time |
| total_price | decimal(12,2) | Line total |
| cost_price | decimal(10,2) | Cost price (for profit calc) |
| timestamps | — | created_at, updated_at |

---

## Key Relationships

| From | To | Type | Foreign Key |
|------|----|------|-------------|
| users | roles | N:1 | `users.role_id` → `roles.id` |
| products | categories | N:1 | `products.category_id` → `categories.id` |
| purchase_orders | suppliers | N:1 | `purchase_orders.supplier_id` → `suppliers.id` |
| purchase_orders | users | N:1 | `purchase_orders.user_id` → `users.id` |
| purchase_order_items | products | N:1 | `purchase_order_items.product_id` → `products.id` |
| grns | purchase_orders | N:1 | `grns.purchase_order_id` → `purchase_orders.id` |
| grns | users | N:1 | `grns.user_id` → `users.id` |
| grn_items | purchase_order_items | N:1 | `grn_items.purchase_order_item_id` → `purchase_order_items.id` |
| grn_items | products | N:1 | `grn_items.product_id` → `products.id` |
| stock_movements | products | N:1 | `stock_movements.product_id` → `products.id` |
| stock_movements | users | N:1 | `stock_movements.user_id` → `users.id` |
| sales | users | N:1 | `sales.user_id` → `users.id` |
| sale_items | products | N:1 | `sale_items.product_id` → `products.id` |
