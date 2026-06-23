# API Endpoints

All API routes are prefixed with `/api` and protected by `auth:sanctum` middleware (Bearer token required).

## Authentication

```bash
# Get a token
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@smartmart.com","password":"password"}'

# Use token in requests
curl http://127.0.0.1:8000/api/products \
  -H "Authorization: Bearer {token}"
```

## Products

### `GET /api/products`
Paginated product list with category.

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "product_code": "PRD-001",
      "product_name": "Organic Bananas",
      "category": { "id": 1, "name": "Fruits" },
      "selling_price": 2.99,
      "quantity": 150
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 20,
    "total": 100
  }
}
```

### `GET /api/products/{id}`
Single product with category.

### `GET /api/products/search?q={term}`
Search by product name, code, or barcode.

**Parameters:**
| Param | Type | Description |
|-------|------|-------------|
| q | string | Search term (matches name, code, barcode) |

## Reports

### `GET /api/reports/dashboard`
Dashboard summary data.

**Response:**
```json
{
  "total_products": 60,
  "low_stock_count": 3,
  "pending_pos": 5,
  "today_sales": 1250.00,
  "sales_trend": [
    { "date": "2024-01-01", "total": 450.00 }
  ],
  "category_distribution": [
    { "category": "Fruits", "count": 15 }
  ]
}
```

### `GET /api/reports/sales-trend?days=7`
Daily sales trend for the last N days.

**Parameters:**
| Param | Type | Default | Description |
|-------|------|---------|-------------|
| days | integer | 7 | Number of days |

### `GET /api/reports/daily-sales?date=YYYY-MM-DD`
Detailed sales for a specific date.

**Parameters:**
| Param | Type | Default | Description |
|-------|------|---------|-------------|
| date | string | today | Date in YYYY-MM-DD format |

## Postman Collection

Import the following into Postman:

```json
{
  "info": { "name": "SmartMart ERP API", "schema": "https://schema.getpostman.com/json/collection/v2.1.0" },
  "item": [
    {
      "name": "Get Products",
      "request": {
        "method": "GET",
        "url": "http://127.0.0.1:8000/api/products",
        "header": [{ "key": "Authorization", "value": "Bearer {{token}}" }]
      }
    },
    {
      "name": "Search Products",
      "request": {
        "method": "GET",
        "url": "http://127.0.0.1:8000/api/products/search?q=banana",
        "header": [{ "key": "Authorization", "value": "Bearer {{token}}" }]
      }
    },
    {
      "name": "Dashboard Report",
      "request": {
        "method": "GET",
        "url": "http://127.0.0.1:8000/api/reports/dashboard",
        "header": [{ "key": "Authorization", "value": "Bearer {{token}}" }]
      }
    },
    {
      "name": "Sales Trend",
      "request": {
        "method": "GET",
        "url": "http://127.0.0.1:8000/api/reports/sales-trend?days=7",
        "header": [{ "key": "Authorization", "value": "Bearer {{token}}" }]
      }
    },
    {
      "name": "Daily Sales",
      "request": {
        "method": "GET",
        "url": "http://127.0.0.1:8000/api/reports/daily-sales",
        "header": [{ "key": "Authorization", "value": "Bearer {{token}}" }]
      }
    }
  ]
}
```
