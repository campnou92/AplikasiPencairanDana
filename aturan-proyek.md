# Aturan Proyek: Sistem Pengajuan dan Pencairan Dana INSTIPER

## Sumber kebenaran
- Requirement: `docs/blueprint.md`. Asumsi SOP: `docs/keputusan.md`.
- Jangan menambah fitur di luar blueprint. Jika ada yang ambigu, pakai `docs/keputusan.md`; jika belum tercakup, tanya saya dulu.
- Ruang lingkup: pengajuan sampai serah-terima ke pembukuan. JANGAN membuat pembukuan, mutasi kas, SPJ, atau akuntansi.

## Stack
- Laravel 11, PHP 8.3, Filament 3 (panel admin), MySQL 8.
- Bahasa antarmuka dan pesan validasi: Bahasa Indonesia. Nama tabel/kolom/kode: Inggris sesuai bagian 10 blueprint.
- Zona waktu: Asia/Jakarta.

## Aturan domain (wajib)
1. Status transaksi mengikuti tabel bagian 8 blueprint. Perpindahan status hanya lewat satu service/state machine; status tidak boleh dilompati.
2. SUDAH DIBAYARKAN dan SUDAH DITERIMA adalah dua status berbeda dan diubah oleh aktor berbeda.
3. Setiap ACC, pengembalian, penolakan, pembayaran, konfirmasi, dan perubahan sensitif wajib menulis `audit_logs` (aktor, aksi, entitas, waktu, data sebelum/sesudah, alasan).
4. Jangan hapus data transaksi. Gunakan status void/koreksi dengan alasan. Pakai soft delete bila perlu.
5. Setelah ACC, nominal/unit/NP/uraian/penerima terkunci. Perubahan hanya lewat alur perubahan + persetujuan ulang.
6. Nominal dibayar tidak boleh melebihi nominal disetujui.
7. Nomor permintaan dan nomor BKK unik, otomatis, tidak dipakai ulang (gunakan transaksi database dan unique index).
8. Nominal disimpan sebagai integer rupiah atau decimal(15,2). Jangan pakai float.
9. Satu akun per orang. Tidak ada akun bersama.
10. Otorisasi memakai Policy/Gate Laravel per role; jangan hanya menyembunyikan menu.

## Role
admin_pencairan (Mba Ririn), approver (Bu Fitri), kepala_biro, penerima, pembukuan, keuangan_arsip, yayasan_arsip, admin_it.

## Cara kerja
- Kerjakan satu tahap per sesi. Susun rencana (implementation plan) dulu dan tunggu persetujuan saya.
- Tiap tahap harus punya migrasi, seeder, dan test (Pest/PHPUnit) yang lulus sebelum dinyatakan selesai.
- Jangan ubah tahap yang sudah selesai kecuali diminta; jika perlu, jelaskan alasannya.
- Di akhir tiap tahap, tulis ringkasan: apa yang dibuat, cara menjalankan, cara mengujinya, dan hal yang belum selesai.
- Jangan commit rahasia (.env, kunci).
