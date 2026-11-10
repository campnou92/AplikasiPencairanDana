# Master Prompt Tahap 1: Master Data dan Akun

Salin isi di antara garis ke Antigravity (mode Planning).

---

Baca `docs/blueprint.md`, `docs/keputusan.md`, dan aturan di `.agent/rules/aturan-proyek.md` terlebih dahulu. Kita membangun aplikasi web "Sistem Pengajuan dan Pencairan Dana INSTIPER" dengan Laravel 11 + Filament 3 + MySQL. Ini TAHAP 1 dari 7: fondasi proyek, master data, dan akun. Jangan mengerjakan fitur tahap berikutnya.

**Susun implementation plan dulu dan tunggu persetujuan saya sebelum menulis kode.**

## Yang dikerjakan

1. **Inisialisasi proyek**
   - Buat project Laravel 11 di folder ini, pasang Filament 3, konfigurasi MySQL lewat `.env.example`, zona waktu Asia/Jakarta, locale Indonesia.
   - Siapkan `README.md` berisi cara instalasi dan menjalankan.

2. **Autentikasi dan role**
   - Login per akun personal (username + password) lewat panel Filament.
   - Role: admin_pencairan, approver, kepala_biro, penerima, pembukuan, keuangan_arsip, yayasan_arsip, admin_it. Gunakan spatie/laravel-permission.
   - Tabel `users`: user_id, nama, username, role, status (aktif/nonaktif).
   - Admin IT dapat mengelola user dan role, tetapi TIDAK mendapat hak ACC, pembayaran, atau konfirmasi.

3. **Master data** (CRUD di Filament, hanya admin_it yang boleh ubah; role lain hanya melihat bila perlu)
   - `units`: unit_id, nama_unit, status.
   - `nps`: kode NP, nama, status.
   - `fiscal_years`: tahun anggaran, status aktif.
   - `payment_methods`: Tunai, Transfer (dapat dikonfigurasi).
   - `expense_types`: Biaya, UM, Lainnya.
   - Pengaturan format nomor (REQ dan BKK) sesuai `docs/keputusan.md` nomor 11, disimpan di tabel pengaturan/config.

4. **Audit log fondasi**
   - Tabel `audit_logs` (log_id, actor, action, entity, entity_id, timestamp, before_after JSON, alasan).
   - Buat trait/service yang bisa dipakai tahap berikutnya, dan terapkan pada perubahan user dan master data.

5. **Seeder**
   - Satu akun contoh per role (password sementara, tampilkan di README), beberapa unit, NP, tahun anggaran contoh, metode pembayaran, jenis pengeluaran.

6. **Dashboard kosong**
   - Halaman "Dashboard Pencairan" placeholder dengan menu sesuai bagian 9 blueprint. Menu yang belum dibuat ditandai "Segera hadir" dan menu tampil sesuai role.

7. **Test**
   - Test login, test pembatasan akses per role (mis. admin_it tidak bisa membuka halaman persetujuan, penerima tidak bisa mengubah master), test audit log tercatat saat master data diubah.

## Kriteria selesai
- `php artisan migrate --seed` berjalan tanpa error.
- Semua test lulus.
- Saya bisa login sebagai tiap role dan melihat menu yang sesuai.
- Mengubah master data menghasilkan baris di `audit_logs`.
- Tidak ada fitur tahap 2 dan seterusnya yang ikut dibuat.

Di akhir, beri ringkasan: file penting yang dibuat, cara menjalankan, cara menguji manual, dan daftar yang belum selesai.
