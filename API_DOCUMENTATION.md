# API Documentation - E-Katalog UMKM

RESTful API untuk sistem manajemen E-Katalog UMKM. API ini menggunakan Laravel Sanctum untuk autentikasi berbasis token.

## Base URL
```
http://127.0.0.1:8000/api
```

## Authentication

API menggunakan **Bearer Token** authentication. Setelah login, gunakan token yang diterima di header setiap request:

```
Authorization: Bearer {your-token-here}
```

---

## 📌 Authentication Endpoints

### 1. Login
**POST** `/api/login`

Login untuk admin/superadmin dan mendapatkan access token.

**Request Body:**
```json
{
  "email": "admin@resto.com",
  "password": "password"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Login berhasil.",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin Kasir",
      "email": "admin@resto.com",
      "role": "admin",
      "is_approved": true
    },
    "token": "1|abc123def456..."
  }
}
```

**Error Responses:**
- `401` - Email atau password salah
- `403` - Bukan admin/superadmin atau belum disetujui

---

### 2. Logout
**POST** `/api/logout`

Logout dan hapus token saat ini.

**Headers:** `Authorization: Bearer {token}`

**Success Response (200):**
```json
{
  "success": true,
  "message": "Logout berhasil."
}
```

---

### 3. Get User Info
**GET** `/api/user`

Mendapatkan informasi user yang sedang login.

**Headers:** `Authorization: Bearer {token}`

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Admin Kasir",
    "email": "admin@resto.com",
    "role": "admin",
    "is_approved": true
  }
}
```

---

## 📦 Products Endpoints

### 1. List Products
**GET** `/api/products`

Mendapatkan daftar produk dengan pagination dan filter.

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `category_id` (optional) - Filter by category ID
- `is_available` (optional) - Filter by availability (true/false)
- `search` (optional) - Search by product name
- `per_page` (optional) - Items per page (default: 15)
- `page` (optional) - Page number

**Example:** `/api/products?category_id=1&search=mie&per_page=10`

**Success Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "category_id": 1,
      "category": {
        "id": 1,
        "name": "Makanan",
        "slug": "makanan"
      },
      "name": "Mie Goreng",
      "slug": "mie-goreng",
      "description": "Mie goreng spesial",
      "price": "15000.00",
      "image_url": "http://127.0.0.1:8000/storage/products/mie-goreng.jpg",
      "is_available": true,
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

---

### 2. Create Product
**POST** `/api/products`

Membuat produk baru.

**Headers:** 
- `Authorization: Bearer {token}`
- `Content-Type: multipart/form-data`

**Request Body (form-data):**
```
category_id: 1
name: Nasi Goreng
description: Nasi goreng spesial
price: 20000
image: [file]
is_available: true
```

**Success Response (201):**
```json
{
  "success": true,
  "message": "Produk berhasil ditambahkan.",
  "data": {
    "id": 2,
    "category_id": 1,
    "name": "Nasi Goreng",
    "slug": "nasi-goreng",
    "price": "20000.00",
    "image_url": "http://127.0.0.1:8000/storage/products/nasi-goreng-123456.jpg",
    "is_available": true
  }
}
```

---

### 3. Show Product
**GET** `/api/products/{id}`

Mendapatkan detail produk.

**Headers:** `Authorization: Bearer {token}`

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "category_id": 1,
    "category": {...},
    "name": "Mie Goreng",
    "price": "15000.00",
    ...
  }
}
```

---

### 4. Update Product
**PUT/PATCH** `/api/products/{id}`

Update produk. Untuk update dengan image, gunakan POST dengan `_method=PUT`.

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "name": "Mie Goreng Special",
  "price": 18000,
  "is_available": false
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Produk berhasil diupdate.",
  "data": {...}
}
```

---

### 5. Delete Product
**DELETE** `/api/products/{id}`

Hapus produk.

**Headers:** `Authorization: Bearer {token}`

**Success Response (200):**
```json
{
  "success": true,
  "message": "Produk berhasil dihapus."
}
```

---

## 🏷️ Categories Endpoints

### 1. List Categories
**GET** `/api/categories`

**Query Parameters:**
- `search` (optional) - Search by name

**Success Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Makanan",
      "slug": "makanan",
      "description": "Kategori makanan",
      "products_count": 5
    }
  ]
}
```

---

### 2. Create Category
**POST** `/api/categories`

**Request Body:**
```json
{
  "name": "Minuman",
  "description": "Kategori minuman"
}
```

---

### 3. Update Category
**PUT** `/api/categories/{id}`

### 4. Delete Category
**DELETE** `/api/categories/{id}`

> ⚠️ Kategori tidak dapat dihapus jika masih memiliki produk.

---

## 🪑 Tables Endpoints

### 1. List Tables
**GET** `/api/tables`

**Query Parameters:**
- `status` (optional) - Filter by status (available/occupied)

---

### 2. Create Table
**POST** `/api/tables`

**Request Body:**
```json
{
  "table_number": "A1",
  "status": "available"
}
```

---

### 3. Update Table
**PUT** `/api/tables/{id}`

### 4. Delete Table
**DELETE** `/api/tables/{id}`

---

## 🛒 Orders Endpoints

### 1. List Orders
**GET** `/api/orders`

**Query Parameters:**
- `status` (optional) - Filter by status (pending/paid/cancelled)
- `payment_method` (optional) - Filter by payment method (cash/qris)
- `table_number` (optional) - Filter by table number
- `start_date` (optional) - Filter from date (YYYY-MM-DD)
- `end_date` (optional) - Filter to date (YYYY-MM-DD)
- `per_page` (optional) - Items per page (default: 15)

**Success Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "table_number": "A1",
      "total_amount": "50000.00",
      "status": "paid",
      "payment_method": "cash",
      "paid_at": "2024-01-01T10:00:00.000000Z",
      "items": [
        {
          "id": 1,
          "product_name": "Mie Goreng",
          "quantity": 2,
          "price_at_purchase": "15000.00",
          "sub_total": "30000.00"
        }
      ],
      "items_count": 2
    }
  ]
}
```

---

### 2. Show Order
**GET** `/api/orders/{id}`

---

### 3. Update Order Status
**PUT** `/api/orders/{id}/status`

**Request Body:**
```json
{
  "status": "paid"
}
```

**Valid statuses:** `pending`, `paid`, `cancelled`

---

### 4. Confirm Cash Payment
**POST** `/api/orders/{id}/confirm-payment`

Konfirmasi pembayaran cash untuk order.

**Success Response (200):**
```json
{
  "success": true,
  "message": "Pembayaran cash berhasil dikonfirmasi.",
  "data": {...}
}
```

---

## 📊 Reports Endpoints

### 1. Sales Report
**GET** `/api/reports/sales`

**Query Parameters:**
- `start_date` (optional) - Start date (YYYY-MM-DD)
- `end_date` (optional) - End date (YYYY-MM-DD)

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "period": {
      "start_date": "2024-01-01",
      "end_date": "2024-01-31"
    },
    "summary": {
      "total_sales": "1500000.00",
      "total_orders": 50,
      "average_order_value": 30000.00
    },
    "by_payment_method": {
      "cash": {
        "count": 30,
        "total": "900000.00"
      },
      "qris": {
        "count": 20,
        "total": "600000.00"
      }
    }
  }
}
```

---

### 2. Dashboard Statistics
**GET** `/api/reports/dashboard`

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "today_sales": "150000.00",
    "total_orders": 100,
    "pending_orders": 5,
    "total_products": 25,
    "available_products": 20,
    "recent_orders": [...]
  }
}
```

---

## 🔒 Error Responses

### Unauthorized (401)
```json
{
  "message": "Unauthenticated."
}
```

### Forbidden (403)
```json
{
  "success": false,
  "message": "Akses ditolak."
}
```

### Validation Error (422)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

### Not Found (404)
```json
{
  "message": "Resource not found."
}
```

---

## 📝 Testing dengan Postman/Insomnia

1. **Login** terlebih dahulu di `/api/login`
2. Copy token dari response
3. Untuk request selanjutnya, tambahkan header:
   ```
   Authorization: Bearer {token-anda}
   ```
4. Test semua endpoint sesuai kebutuhan

---

## 🚀 Example Usage (cURL)

### Login
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@resto.com",
    "password": "password"
  }'
```

### Get Products
```bash
curl -X GET http://127.0.0.1:8000/api/products \
  -H "Authorization: Bearer {your-token}"
```

### Create Product
```bash
curl -X POST http://127.0.0.1:8000/api/products \
  -H "Authorization: Bearer {your-token}" \
  -F "category_id=1" \
  -F "name=Nasi Goreng" \
  -F "price=20000" \
  -F "image=@/path/to/image.jpg"
```

---

**Dokumentasi ini dibuat untuk API versi 1.0**
