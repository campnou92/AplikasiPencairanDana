# Sistem Pengajuan dan Pencairan Dana INSTIPER

Aplikasi web administrasi pencairan dana internal Institut Pertanian Stiper (INSTIPER) Yogyakarta, dibangun dengan **Laravel 11**, **Filament 3**, dan **spatie/laravel-permission**.

> Status Pengembangan: **Tahap 1 dari 7 (Fondasi Proyek, Master Data, dan Akun)**

---

## 1. Persyaratan Sistem

- **PHP**: 8.2 / 8.3 (dengan ekstensi `pdo`, `pdo_mysql`/`pdo_sqlite`, `curl`, `mbstring`, `intl`, `fileinfo`, `zip`)
- **Composer**: >= 2.x
- **Database**: MySQL 8.0+ (atau SQLite untuk uji coba lokal & testing)
- **Node.js & npm** (opsional untuk build aset front-end jika diperlukan)

---

## 2. Cara Instalasi & Menjalankan

### Langkah 1: Kloning / Buka Folder Proyek
Masuk ke direktori root proyek ini di terminal:
```bash
cd "c:\Users\ARIF\Downloads\Aplikasi Pencairan Dana"
```

### Langkah 2: Salin File Konfigurasi Environment
```bash
copy .env.example .env
```
Sesuaikan konfigurasi database di file `.env` jika menggunakan MySQL server lokal:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pencairan_dana
DB_USERNAME=root
DB_PASSWORD=
```
*(Catatan: Untuk pengujian langsung tanpa menjalankan daemon MySQL, Anda dapat menggunakan `DB_CONNECTION=sqlite`)*

### Langkah 3: Generate Application Key
```bash
php artisan key:generate
```

### Langkah 4: Jalankan Migrasi dan Seeder
```bash
php artisan migrate:fresh --seed
```
Perintah ini akan membuat semua tabel:
- `users` (dengan username personal, role, status aktif/nonaktif)
- Tabel Spatie Permission (`roles`, `permissions`, `model_has_roles`)
- Master data: `units`, `nps`, `fiscal_years`, `payment_methods`, `expense_types`, `app_settings`
- Fondasi jejak audit: `audit_logs`

### Langkah 5: Jalankan Server Lokal
```bash
php artisan serve
```
Akses panel admin Filament di browser:
👉 **http://localhost:8000/admin**

---

## 3. Akun Pengguna Contoh (Seeder)

Semua akun menggunakan kata sandi default sementara:  
🔑 **Password:** `Password123!`

| Role / Peran | Username | Nama Akun | Keterangan Akses |
|---|---|---|---|
| **admin_it** | `admin_it` | Administrator IT | Mengelola user & master data. **Dilarang keras** melakukan ACC, bayar, atau konfirmasi. |
| **admin_pencairan** | `admin_pencairan` | Mba Ririn (Admin Pencairan) | Input pengajuan, rekap harian, buat BKK, catat pembayaran. |
| **approver** | `approver` | Bu Fitri (Approver Keuangan) | Memeriksa dan memberikan ACC per permohonan. |
| **kepala_biro** | `kepala_biro` | Kepala Biro | Pengesahan BKK. |
| **penerima** | `penerima` | Budi Santoso (Penerima Dana) | Konfirmasi penerimaan dana (tanpa tanda tangan gambar). |
| **pembukuan** | `pembukuan` | Petugas Pembukuan | Menerima antrean BKK yang telah dibayar & diterima. |
| **keuangan_arsip** | `keuangan_arsip` | Petugas Arsip Keuangan | Akses digital arsip BKK Keuangan. |
| **yayasan_arsip** | `yayasan_arsip` | Petugas Arsip Yayasan | Akses digital arsip BKK Yayasan. |

---

## 4. Fitur yang Diselesaikan (Tahap 1)

1. **Inisialisasi Proyek**:
   - Laravel 11.57 + Filament 3.3.
   - Konfigurasi zona waktu `Asia/Jakarta`, locale Indonesia (`id`).
2. **Autentikasi & Akun Personal**:
   - Login menggunakan **Username** dan **Password** pada panel Filament.
   - 8 Peran Spatie (`admin_pencairan`, `approver`, `kepala_biro`, `penerima`, `pembukuan`, `keuangan_arsip`, `yayasan_arsip`, `admin_it`).
   - Validasi status akun (akun nonaktif dicegah login dan dicatat di audit log).
3. **Master Data CRUD**:
   - `units`: Unit Kerja (Biro Administrasi Umum, Fakultas Pertanian, Biro Keuangan).
   - `nps`: Nomor Pos (Operasional Kantor, Praktikum & Perkuliahan, Kegiatan Mahasiswa).
   - `fiscal_years`: Tahun Anggaran (2025 nonaktif, 2026 aktif).
   - `payment_methods`: Metode Pembayaran (Tunai, Transfer).
   - `expense_types`: Jenis Pengeluaran (Biaya, UM, Lainnya).
   - `app_settings`: Pengaturan Format nomor `REQ/{tahun}/{urut}` dan `BKK/{tahun_anggaran}/{urut}`.
   - Hanya `admin_it` yang memiliki hak membuat, mengubah, dan menghapus master data.
4. **Pondasi Audit Log**:
   - Tabel `audit_logs` menyimpan jejak: `actor`, `action`, `entity`, `entity_id`, `timestamp`, `before_after` (JSON snapshot sebelum dan sesudah), serta `reason`.
   - Trait `Auditable` terpasang pada model master data dan user.
   - Layanan `AuditService` siap digunakan untuk tahap berikutnya.
5. **Dashboard Pencairan Placeholder**:
   - Menampilkan widget ringkasan status sesuai Bagian 9 Blueprint.
   - Menu navigasi dinamis berbasis role dengan badge *"Segera hadir"* untuk menu Tahap 2 ke atas.
6. **Otorisasi & Pemisahan Tugas (SoD)**:
   - Laravel Gates memastikan `admin_it` tidak dapat mengakses approval, pembayaran, atau konfirmasi penerimaan.

---

## 5. Menjalankan Pengujian Otomatis

Jalankan test suite menggunakan PHPUnit / Pest:
```bash
php artisan test
```
Seluruh 15 skenario pengujian mencakup:
- Keberadaan 8 role dan akun seed.
- Login username + password (berhasil & gagal).
- Pembatasan akun nonaktif.
- Otorisasi CRUD master data per role.
- Integritas jejak audit log (`before_after` capture).
- Pemisahan tugas (SoD) `admin_it` vs `approver` vs `admin_pencairan` vs `penerima`.

