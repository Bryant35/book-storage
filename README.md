
# Web Perpustakaan Laravel

Proyek ini adalah sistem manajemen perpustakaan berbasis Laravel. Kamu dapat melihat daftar buku, kategori, dan penulis, serta melakukan CRUD jika login sebagai admin.

---

## A. Konfigurasi Untuk Memulai Web

### 1. Clone / Download Repository
#### Clone:
```bash
git clone https://github.com/Bryant35/book-storage
```
```bash
cd book-storage
```


#### Atau Download ZIP:
- Klik tombol `Code` → `Download ZIP`
- Ekstrak file ZIP-nya, lalu buka folder hasil ekstraksi

### 2. Setup File Konfigurasi
Copy file `.env.example` ke `.env` melalui terminal:
```bash
cp .env.example .env
```
> Ini akan menyalin file konfigurasi contoh (`.env.example`) ke file `.env` yang akan digunakan aplikasi Laravel.

### 3. Jalankan Web Server
Buka aplikasi seperti **XAMPP**, **DBEngine**, atau aplikasi lain yang dapat menjalankan **server localhost** dan **MySQL/MariaDB**.

### 4. Install Dependency
```bash
npm install
```
```bash
composer install
```

### 5. Generate Key
```bash
php artisan key:generate
```

### 6. Jalankan Migration & Seeder
```bash
php artisan migrate --seed
```

> Setelah proses selesai, akun admin default akan tersedia:
- **Username**: `admin`
- **Password**: `admin`

### 7. Jalankan Development Server
```bash
composer run dev
```

---

## B. Penggunaan Web

1. Sebelum login (sebagai guest), hanya dapat melihat list **Book**, **Author**, dan **Category**.
2. Untuk akses admin, klik tombol **Login** di pojok kiri bawah, lalu masukkan:
   - **Username**: `admin`
   - **Password**: `admin`
3. Setelah login sebagai admin, kamu bisa melakukan **CRUD (Create, Read, Update, Delete)**.
4. Untuk membuat buku dengan kategori & penulis baru, **tambah dulu kategori dan penulisnya secara manual** dari halaman kategori dan penulis.
5. Untuk menambahkan buku:
   - Pilih penulis & kategori
   - Isi konten buku (deskripsi singkat atau isi awal seperti sinopsis)
