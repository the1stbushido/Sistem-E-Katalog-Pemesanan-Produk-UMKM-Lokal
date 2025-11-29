# 🍽️ Sistem E-Katalog Pemesanan Produk UMKM Lokal

Sistem manajemen katalog dan pemesanan produk UMKM berbasis web dengan fitur RESTful API untuk integrasi mobile app.

## 📋 Deskripsi Proyek

Aplikasi web untuk mengelola katalog produk UMKM lokal dengan sistem pemesanan digital. Dilengkapi dengan RESTful API yang memungkinkan admin mengelola sistem melalui aplikasi mobile.

### Fitur Utama

#### 🛍️ Customer (Pelanggan)
- Pilih nomor meja sebelum memesan
- Browse katalog produk berdasarkan kategori
- Keranjang belanja (session-based)
- Checkout dengan 2 metode pembayaran (Cash & QRIS)
- Halaman pembayaran QRIS dengan timer
- Konfirmasi pesanan

#### 👨‍💼 Admin
- Dashboard dengan statistik penjualan
- CRUD Produk (dengan upload gambar)
- CRUD Kategori
- CRUD Meja
- Manajemen pesanan
- Konfirmasi pembayaran cash
- Laporan penjualan

#### 👑 Superadmin
- Manajemen akun admin (approve, ubah password, hapus)
- Dashboard khusus superadmin
- Akses penuh ke semua fitur admin

#### 🔌 RESTful API
- Token-based authentication (Laravel Sanctum)
- 21 endpoints untuk manajemen lengkap
- Role-based access control
- Dokumentasi API lengkap

---

## 🛠️ Tech Stack

- **Framework**: Laravel 12
- **PHP**: 8.2+
- **Database**: MySQL
- **Authentication**: Laravel Breeze + Sanctum
- **Frontend**: Blade Templates + Tailwind CSS
- **API**: RESTful API with Laravel Sanctum

---

## 📦 Instalasi

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL
- Node.js & NPM

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/Sistem-E-Katalog-Pemesanan-Produk-UMKM-Lokal.git
   cd Sistem-E-Katalog-Pemesanan-Produk-UMKM-Lokal
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   
   Edit file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ekatalog_umkm
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Create Database**
   ```bash
   mysql -u root -e "CREATE DATABASE ekatalog_umkm"
   ```

6. **Run Migration**
   ```bash
   php artisan migrate
   ```

7. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

8. **Build Assets**
   ```bash
   npm run build
   ```

9. **Run Server**
   ```bash
   php artisan serve
   ```

10. **Access Application**
    - Web: http://127.0.0.1:8000
    - API: http://127.0.0.1:8000/api

---

## 👤 Default Users

Setelah migration, buat user admin/superadmin dengan:

```bash
php artisan tinker
```

```php
// Buat Superadmin
$user = new App\Models\User();
$user->name = 'Super Admin';
$user->email = 'superadmin@example.com';
$user->password = bcrypt('password');
$user->role = 'superadmin';
$user->is_approved = true;
$user->save();

// Buat Admin
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = bcrypt('password');
$user->role = 'admin';
$user->is_approved = true;
$user->save();
```

---

## 📚 Dokumentasi API

Dokumentasi lengkap API tersedia di: **[API_DOCUMENTATION.md](API_DOCUMENTATION.md)**

### Quick Start API

#### 1. Login
```bash
POST http://127.0.0.1:8000/api/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

#### 2. Get Products
```bash
GET http://127.0.0.1:8000/api/products
Authorization: Bearer {your-token}
```

#### 3. Create Product
```bash
POST http://127.0.0.1:8000/api/products
Authorization: Bearer {your-token}
Content-Type: multipart/form-data

category_id: 1
name: Nasi Goreng
price: 20000
image: [file]
```

---

## 🗂️ Struktur Database

### Tables
- `users` - Data user (admin/superadmin)
- `categories` - Kategori produk
- `products` - Produk UMKM
- `tables` - Meja restoran/cafe
- `orders` - Pesanan pelanggan
- `order_items` - Detail item pesanan
- `sessions` - Session management
- `personal_access_tokens` - API tokens (Sanctum)

---

## 🔐 Role & Permissions

| Role | Web Access | API Access | Permissions |
|------|-----------|-----------|-------------|
| **Customer** | ✅ | ❌ | Browse, Order |
| **Admin** | ✅ | ✅ | Manage Products, Orders, Reports |
| **Superadmin** | ✅ | ✅ | Full Access + Admin Management |

---

## 🚀 Fitur API

### Authentication
- ✅ Login with token
- ✅ Logout (revoke token)
- ✅ Get user info

### Products
- ✅ List with filters & pagination
- ✅ Create with image upload
- ✅ Update
- ✅ Delete

### Categories
- ✅ Full CRUD operations

### Tables
- ✅ Full CRUD operations
- ✅ Status filtering

### Orders
- ✅ List with filters
- ✅ View details
- ✅ Update status
- ✅ Confirm payment

### Reports
- ✅ Sales report
- ✅ Dashboard statistics

---

## 📱 Mobile App Integration

API ini siap digunakan untuk mobile app dengan flow:

1. **Login** → Dapatkan token
2. **Store token** securely (SharedPreferences/Keychain)
3. **Include token** di setiap request: `Authorization: Bearer {token}`
4. **Handle responses** sesuai format JSON

---

## 🧪 Testing

### Test dengan Postman

1. Import collection atau buat manual
2. Set base URL: `http://127.0.0.1:8000/api`
3. Login untuk mendapatkan token
4. Set Authorization: Bearer Token
5. Test semua endpoint

### Test dengan cURL

```bash
# Login
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

# Get Products
curl -X GET http://127.0.0.1:8000/api/products \
  -H "Authorization: Bearer {token}"
```

---

## 📝 Development Notes

### Middleware
- `auth:sanctum` - API authentication
- `api_role:admin,superadmin` - Role-based access for API
- `role:admin,superadmin` - Role-based access for web

### API Resources
Semua response API menggunakan Resource classes untuk format konsisten:
- `UserResource`
- `ProductResource`
- `CategoryResource`
- `TableResource`
- `OrderResource`
- `OrderItemResource`

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📄 License

This project is licensed under the MIT License.

---

## 👨‍💻 Author

**Tio Andrian**

---

## 📞 Support

Untuk pertanyaan atau bantuan, silakan buka issue di repository ini.

---

## 🙏 Acknowledgments

- Laravel Framework
- Laravel Breeze
- Laravel Sanctum
- Tailwind CSS
- All contributors

---

**Made with ❤️ for UMKM Indonesia**