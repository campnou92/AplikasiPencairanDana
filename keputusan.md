# Keputusan dan Asumsi Sementara

Asumsi ini dipakai sampai pemilik proses (Mba Ririn, Bu Fitri, Kepala Biro) memvalidasi SOP. Jika berubah, perbarui file ini DAN kode.

| No | Topik | Keputusan sementara | Status |
|---|---|---|---|
| 1 | ACC Bu Fitri | Per baris permintaan; rekap harian hanya tampilan batch | Asumsi |
| 2 | Struktur BKK | Satu BKK per permintaan/transaksi; tampilan jadwal dikelompokkan per unit | Asumsi |
| 3 | Pengesahan Kepala Biro | Wajib SEBELUM pembayaran; sediakan pengaturan (config) untuk mengubah ke "bersamaan" | Asumsi |
| 4 | Tanggal pencairan | H+1 kalender; Mba Ririn boleh ubah dengan alasan wajib | Asumsi |
| 5 | Metode pembayaran | Tunai dan Transfer; daftar bisa dikonfigurasi | Asumsi |
| 6 | Konfirmasi penerima | Login akun penerima (utama); opsi kios/kode sekali pakai disiapkan nanti | Asumsi |
| 7 | Penerima vs pemohon | Default = pemohon; bisa dipilih beda sebelum pembayaran | Asumsi |
| 8 | Pembayaran sebagian | Tidak didukung | Asumsi |
| 9 | Arsip Yayasan | Arsip PDF digital menggantikan lembar fisik | Perlu persetujuan resmi |
| 10 | Jenis persetujuan | e-approval terautentikasi, bukan TTE tersertifikasi | Asumsi |
| 11 | Format nomor | Permintaan: REQ/{tahun}/{urut 5 digit}. BKK: BKK/{tahun_anggaran}/{urut 5 digit}. Urutan reset per tahun, tidak dipakai ulang | Asumsi |
| 12 | Jenis pengeluaran | Biaya, UM, Lainnya | Asumsi |
