# Sistem Manajemen Laporan Keuangan

Aplikasi web untuk mengelola laporan keuangan dengan sistem multi-role (Admin & User). Aplikasi ini memungkinkan pengguna untuk membuat laporan pemasukan dan pengeluaran, sementara admin dapat memverifikasi dan mengelola laporan tersebut.

## Deskripsi Aplikasi

Sistem Manajemen Laporan Keuangan adalah aplikasi berbasis web yang dirancang untuk memudahkan pencatatan dan pengelolaan transaksi keuangan. Aplikasi ini dilengkapi dengan sistem autentikasi, manajemen tugas, dan fitur pelaporan yang komprehensif dengan dukungan ekspor PDF.

## Fitur Utama

### Fitur Admin
- **Dashboard Admin** - Statistik dan overview laporan keuangan
- **Manajemen User** - Kelola data pengguna (CRUD)
- **Verifikasi Laporan** - Review dan verifikasi laporan dari user dengan status (Menunggu, Diproses, Selesai)
- **Manajemen Tugas** - Assign tugas kepada user dengan lampiran file
- **Laporan Keuangan** - Lihat semua laporan dengan filter lokasi dan status
- **Export PDF** - Cetak laporan dalam format PDF
- **Registrasi User** - Tambah user baru ke sistem

### Fitur User
- **Dashboard User** - Ringkasan laporan pribadi
- **Buat Laporan** - Input laporan pemasukan/pengeluaran dengan:
  - Judul dan deskripsi
  - Nominal pemasukan dan pengeluaran
  - Upload gambar bukti
  - Pilih lokasi (Salem, Bentar, Bentarsari, Bumiayu, Cilacap)
  - Tanggal transaksi
- **Kelola Laporan** - Edit dan hapus laporan pribadi
- **Manajemen Tugas** - Lihat tugas yang ditugaskan dan submit hasil pekerjaan
- **Profile Management** - Update data profil dan foto

### Fitur Umum
- **Autentikasi** - Login/Logout dengan role-based access
- **Real-time Updates** - Menggunakan Livewire untuk interaksi dinamis
- **Responsive Design** - Tampilan optimal di berbagai perangkat
- **Multi-lokasi** - Support untuk beberapa lokasi cabang

## Teknologi yang Digunakan

### Backend
- **Laravel 12** - PHP Framework
- **PHP 8.2+** - Programming Language
- **SQLite** - Database
- **Laravel Sanctum** - API Authentication
- **Livewire 3.6** - Full-stack framework untuk Laravel

### Frontend
- **Tailwind CSS 4.0** - Utility-first CSS Framework
- **Vite 7** - Frontend Build Tool
- **Alpine.js** - Lightweight JavaScript Framework (via Livewire)

### Libraries & Tools
- **DomPDF** - PDF Generation
- **Laravel Pint** - Code Style Fixer
- **Concurrently** - Run multiple commands simultaneously

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite (atau database lain yang didukung Laravel)

## Cara Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd <project-folder>
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Konfigurasi Environment
```bash
# Copy file environment
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Atau buat file database SQLite:
```bash
type nul > database\database.sqlite
```

### 5. Migrasi Database
```bash
php artisan migrate
```

### 6. Storage Link
```bash
php artisan storage:link
```

### 7. (Opsional) Seed Data
Jika tersedia seeder untuk data dummy:
```bash
php artisan db:seed
```

## Cara Menjalankan Project

### Metode 1: Menggunakan Composer Script (Recommended)
```bash
composer dev
```
Script ini akan menjalankan secara bersamaan:
- Laravel development server (http://localhost:8000)
- Queue worker
- Vite dev server

### Metode 2: Manual (Terminal Terpisah)

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 - Vite Dev Server:**
```bash
npm run dev
```

**Terminal 3 - Queue Worker (Opsional):**
```bash
php artisan queue:listen
```

### Build untuk Production
```bash
# Build assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Akses Aplikasi

Setelah menjalankan server, akses aplikasi melalui browser:
- **URL:** http://localhost:8000
- **Login:** http://localhost:8000/login

### Default Credentials
Sesuaikan dengan data seeder atau buat user manual melalui registrasi.

## Struktur Folder Utama

```
├── app/
│   ├── Http/          # Controllers & Middleware
│   ├── Livewire/      # Livewire Components
│   ├── Models/        # Eloquent Models
│   └── Services/      # Business Logic Services
├── database/
│   ├── migrations/    # Database Migrations
│   └── seeders/       # Database Seeders
├── resources/
│   ├── views/         # Blade Templates
│   ├── css/           # Stylesheets
│   └── js/            # JavaScript Files
├── routes/
│   └── web.php        # Web Routes
└── public/            # Public Assets
```

## Testing

Jalankan test suite:
```bash
composer test
```

Atau:
```bash
php artisan test
```

## Troubleshooting

### Error: Permission Denied
```bash
# Windows (Run as Administrator)
icacls storage /grant Users:F /T
icacls bootstrap\cache /grant Users:F /T
```

### Error: Vite Manifest Not Found
```bash
npm run build
```

### Error: Database Locked
Pastikan tidak ada proses lain yang mengakses database SQLite.

## Kontribusi

Jika ingin berkontribusi pada project ini:
1. Fork repository
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## Lisensi

Project ini menggunakan lisensi [MIT License](https://opensource.org/licenses/MIT).

## Kontak & Support

Untuk pertanyaan atau dukungan, silakan hubungi tim development atau buat issue di repository ini.

---


