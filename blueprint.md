# Blueprint Sistem Informasi Keuangan INSTIPER
## Modul Administrasi Pengajuan dan Pencairan Dana (v0.1, 5 November 2026)

Ruang lingkup: pengajuan masuk sampai dana dibayarkan dan dikonfirmasi diterima.
Sumber asli: Blueprint_Admin_Pencairan_Dana_INSTIPER.pdf

## 1. Tujuan

Semua pengajuan dan pencairan dana tercatat dalam satu sistem web, mengurangi pencatatan berulang, memperjelas status tiap permintaan, dan menghilangkan kebutuhan mencetak BKK tiga rangkap NCR.

Hasil yang diharapkan:
- Semua permintaan dana tercatat (langsung dari orang/unit/pimpinan, atau dari surat masuk).
- Mba Ririn punya satu daftar kerja harian.
- Bu Fitri memeriksa dan memberi ACC per permintaan melalui rekap.
- Pengajuan yang disetujui masuk daftar pencairan hari berikutnya.
- BKK dibuat dari data pengajuan (tanpa ketik ulang).
- Penerima mengonfirmasi penerimaan lewat sistem, tanpa tanda tangan gambar.
- Hanya 1 lembar dicetak untuk pengaju; arsip Keuangan dan Yayasan disimpan digital.

### Prinsip desain
| Prinsip | Penerapan |
|---|---|
| Satu sumber data | Satu nomor permintaan dan satu nomor BKK menghubungkan seluruh tahapan. |
| Jejak audit | Setiap perubahan, ACC, pembayaran, konfirmasi menyimpan pelaku, tanggal, jam, alasan. |
| Pemisahan tugas | Admin pencairan, pemberi persetujuan, penerima, pembukuan punya tindakan berbeda. |
| Digital-first | PDF dan arsip elektronik standar; cetak fisik hanya 1 lembar untuk pengaju. |
| Status tidak boleh dilompati | Tidak bisa dibayar sebelum ACC; tidak bisa dikonfirmasi sebelum pembayaran dicatat. |

## 2. Batas ruang lingkup

### Termasuk
- Pengajuan langsung dari individu/unit/pimpinan.
- Pencatatan surat masuk sebagai dasar permintaan.
- Data permintaan dan lampiran.
- Rekap harian oleh Mba Ririn.
- Review dan ACC awal oleh Bu Fitri.
- Penjadwalan pencairan hari berikutnya.
- Pembuatan BKK per unit/kebutuhan dan pengesahan Kepala Biro.
- Pencatatan pembayaran oleh Mba Ririn/petugas kas.
- Konfirmasi penerimaan oleh penerima.
- Cetak 1 lembar untuk pengaju; 2 arsip digital.

### Belum termasuk (tahap berikutnya)
- Pembukuan transaksi.
- Mutasi Kas harian/bulanan/tahunan.
- Monitoring SPJ, penyelesaian UM, pengembalian sisa dana, rekonsiliasi.
- Persetujuan akhir BKK oleh Bu Fitri setelah pembukuan.
- Modul akuntansi, jurnal, buku besar, laporan keuangan.

### Batas integrasi
Di akhir modul ini, sistem hanya menyiapkan BKK yang sudah dibayar dan dikonfirmasi diterima sebagai antrean/dokumen untuk pembukuan.

### Tiga tahap persetujuan (jangan dicampur)
| Tahap | Pelaku | Waktu | Cakupan |
|---|---|---|---|
| ACC daftar permintaan pencairan | Bu Fitri | Sebelum pencairan | Termasuk |
| Pengesahan BKK | Kepala Biro | Tercantum di BKK; waktu belum diputuskan | Termasuk sebagai langkah BKK |
| Persetujuan akhir BKK | Bu Fitri | Setelah pembukuan | DI LUAR cakupan |

## 3. Alur utama

A. Penerimaan, rekap, ACC awal:
Pengajuan langsung/surat masuk -> Mba Ririn input dan verifikasi -> Rekap harian -> Bu Fitri review dan ACC -> Disetujui? 
- Ya: antrean pencairan hari berikutnya.
- Tidak: dikembalikan/ditolak dengan catatan.

B. BKK, pembayaran, konfirmasi, arsip:
Mba Ririn buat BKK -> Pengesahan Kepala Biro -> Mba Ririn bayarkan dana -> Catat nominal, waktu, metode, petugas -> Penerima konfirmasi penerimaan -> PDF BKK final -> (Cetak 1 lembar untuk pengaju) + (2 arsip digital Keuangan dan Yayasan) -> Siap diserahkan ke pembukuan.

## 4. Aktor dan hak

| Aktor | Tanggung jawab | Tindakan di sistem |
|---|---|---|
| Pengaju/pemohon | Mengajukan kebutuhan dana | Mengajukan ke admin (portal opsional kelak); menerima salinan BKK |
| Sumber surat masuk | Surat dasar permintaan | Dicatat Mba Ririn dan dilampirkan |
| Mba Ririn | Admin penerimaan, rekap, BKK, pencairan | Input/edit sebelum ACC; susun rekap; ajukan ACC; buat BKK; catat pembayaran; kirim permintaan konfirmasi; cetak 1 lembar |
| Bu Fitri | ACC awal | Lihat rekap; setujui, kembalikan, atau tolak dengan catatan |
| Kepala Biro | Pengesahan BKK | Persetujuan BKK di sistem atau tanda tangan sesuai metode yang disepakati |
| Penerima dana | Orang yang menerima uang | Periksa nama dan nominal, lalu konfirmasi |
| Bagian pembukuan | Penerima hasil proses | Lihat/tarik BKK berstatus dibayar dan diterima; tidak mengubah proses admin |
| Admin IT | Akun, master data, konfigurasi, keamanan | Atur akses, tanpa mengambil alih persetujuan transaksi |

Pemisahan tugas wajib: admin pencairan mencatat dan membayar; Bu Fitri ACC awal; Kepala Biro mengesahkan; penerima mengonfirmasi.

## 5. Proses bisnis rinci

### 5.1 Penerimaan permintaan
Dua jalur, keduanya masuk daftar permintaan Mba Ririn:
- **Pengajuan langsung**: catat pemohon, unit, kebutuhan, nominal, tanggal permintaan, dokumen pendukung.
- **Surat masuk**: catat nomor surat, tanggal surat, pengirim, perihal, tanggal diterima, lampiran; hubungkan ke permintaan dana.

Data minimum permintaan:
| Field | Keterangan |
|---|---|
| ID Permintaan | Nomor unik otomatis |
| Tanggal diterima | Tanggal diterima administrasi |
| Sumber permintaan | Langsung / Surat Masuk |
| Pemohon/pengirim | Orang, unit, pimpinan, atau pihak pada surat |
| Unit | Unit terkait kebutuhan dana |
| Uraian kebutuhan | Tujuan penggunaan dana |
| Nominal diminta | Nilai dana dimohonkan |
| NP | Kode NP dari master |
| Penerima dana | Orang yang direncanakan menerima uang; boleh beda dari pemohon |
| Lampiran | Surat, disposisi, rincian, dokumen pendukung |
| Tanggal kebutuhan | Tanggal dana diperlukan (info penjadwalan) |

### 5.2 Rekap harian (Mba Ririn)
- Tampilkan semua permintaan yang diterima hari berjalan.
- Filter: unit, sumber, pemohon, nominal, tanggal kebutuhan, status.
- Mba Ririn memeriksa kelengkapan sebelum rekap dikirim ke Bu Fitri.
- Dikirim sebagai satu batch, tetapi keputusan ACC tercatat PER PERMINTAAN.

### 5.3 Review dan ACC awal (Bu Fitri)
| Keputusan | Perilaku sistem |
|---|---|
| ACC | Status disetujui, masuk antrean penjadwalan |
| Dikembalikan | Kembali ke Mba Ririn dengan catatan koreksi; histori tetap disimpan |
| Ditolak | Berstatus ditolak, tidak boleh dijadwalkan bayar; alasan wajib |

Kontrol: setelah ACC, Mba Ririn tidak bisa mengubah nominal, unit, NP, uraian, atau penerima tanpa permintaan perubahan tercatat dan persetujuan ulang.

### 5.4 Penjadwalan pencairan
- ACC masuk daftar pencairan hari berikutnya; tanggal rencana terisi otomatis; antrean ditampilkan per unit.
- Status: DISETUJUI - TERJADWAL.
- Simpan tanggal ACC, pemberi ACC, tanggal rencana pencairan.
- Jika ditunda: Mba Ririn pilih tanggal baru + alasan; tanggal lama disimpan sebagai histori.
- Yang belum ACC tidak boleh masuk daftar siap bayar.

### 5.5 Pembuatan BKK
Pada hari pencairan, Mba Ririn membuat BKK dari permintaan yang disetujui, disusun per unit.
| Data BKK | Aturan |
|---|---|
| Unit | Dari permintaan |
| Nomor BKK | Otomatis, unik; format dapat dikonfigurasi per tahun anggaran |
| Tahun Anggaran | Dari master tahun anggaran |
| NP | Dari master NP |
| Uraian | Dari permintaan; koreksi sebelum bayar harus tercatat |
| Jumlah | Dari nominal yang di-ACC |
| Tanggal | Tanggal dokumen/pencairan yang benar |
| Jenis pengeluaran | Biaya, UM, atau kategori lain sesuai daftar |
| Penerima | Pihak yang benar-benar menerima dana |
| Sumber | ID Permintaan dan nomor surat masuk bila ada |

### 5.6 Pengesahan BKK oleh Kepala Biro
BKK memuat "Disetujui Kepala Biro". Sediakan tindakan persetujuan dengan akun Kepala Biro (atau mekanisme TTE sesuai institusi). Waktu (sebelum atau bersamaan pembayaran) perlu diputuskan di SOP.

### 5.7 Pembayaran
- Mba Ririn/petugas kas membayar dana secara nyata.
- Setelah benar-benar dibayar, status menjadi SUDAH DIBAYARKAN.
- Catat tanggal dan jam, petugas, nominal dibayar, metode, rekening/kas sumber.
- Nominal aktual tidak boleh melebihi nominal disetujui tanpa persetujuan perubahan.
- Jika gagal/belum terjadi, status tetap belum dibayar dan alasan dicatat.

## 6. Konfirmasi penerimaan tanpa tanda tangan

Nama penerima tampil otomatis dari BKK, tetapi status SUDAH DITERIMA hanya muncul setelah penerima mengonfirmasi sendiri.

### Tampilan konfirmasi
Nomor BKK; nama penerima (otomatis); unit dan uraian; nominal yang dibayarkan; pernyataan "Saya menyatakan telah menerima dana sesuai nominal yang tercantum."; tombol "Saya Sudah Menerima Dana".

### Autentikasi (pilihan teknis)
| Pilihan | Cara kerja |
|---|---|
| Akun penerima | Penerima login ke akunnya lalu menekan konfirmasi |
| OTP / kode sekali pakai | Kode dikirim ke kontak terdaftar atau kode transaksi diverifikasi |
| Kios/tablet di loket | Penerima konfirmasi sendiri di perangkat; harus ada autentikasi agar petugas tidak mengonfirmasi atas nama penerima |

### Data audit konfirmasi
ID BKK dan ID permintaan; nama penerima; status (menunggu/diterima/ditolak-salah data); tanggal dan jam; identitas akun/metode verifikasi; metadata teknis seperlunya.

Catatan: ini bukti elektronik untuk administrasi internal. Jika INSTIPER mewajibkan TTE tersertifikasi, itu kebutuhan terpisah.

## 7. BKK, cetak, arsip digital

BKK = satu dokumen digital, satu nomor. PDF final dibuat setelah pembayaran dicatat dan penerimaan dikonfirmasi.

| Tujuan | Distribusi | Perlakuan |
|---|---|---|
| Pengaju | 1 lembar cetak dan/atau PDF | Diunduh/dicetak Mba Ririn setelah pembayaran dan penerimaan lengkap |
| Keuangan | Arsip digital | PDF + metadata otomatis tersimpan; akses sesuai hak |
| Yayasan | Arsip digital | Tersimpan di arsip Yayasan/folder distribusi; akses sesuai kebijakan |

### Komponen BKK
- Identitas: logo INSTIPER, judul, nomor, tanggal, tahun anggaran.
- Rincian: unit, NP, uraian, jenis pengeluaran, jumlah (angka dan terbilang).
- Sumber pengajuan: ID permintaan, jenis sumber, nomor surat bila ada.
- Otorisasi: Disetujui Kepala Biro, Dibayarkan oleh, Diterima oleh, Dibukukan oleh, Diajukan oleh.
- Penerimaan: nama penerima + "dikonfirmasi secara elektronik" + tanggal/jam.
- Verifikasi: QR Code/tautan verifikasi, status, nomor dokumen.

Nama petugas pembayar dan penerima dicatat otomatis dari akun. "Dibukukan oleh" menunggu tahap pembukuan. Jangan menempel gambar tanda tangan sebagai satu-satunya otorisasi.

## 8. Status transaksi

| Status | Makna | Pengubah |
|---|---|---|
| DRAFT | Data sedang diinput, belum diajukan | Mba Ririn |
| DITERIMA ADMIN | Tercatat dan punya ID | Mba Ririn |
| MASUK REKAP HARIAN | Masuk daftar periksa Bu Fitri | Sistem / Mba Ririn |
| MENUNGGU ACC | Menunggu keputusan Bu Fitri | Sistem |
| DIKEMBALIKAN | Perlu koreksi; ada catatan | Bu Fitri |
| DITOLAK | Tidak disetujui | Bu Fitri |
| DISETUJUI - TERJADWAL | ACC awal; dijadwalkan hari berikutnya | Bu Fitri / sistem |
| BKK DIBUAT | BKK dihasilkan dari permintaan | Mba Ririn |
| MENUNGGU PENGESAHAN BKK | Menunggu Kepala Biro bila wajib sebelum bayar | Sistem |
| SIAP DIBAYARKAN | Syarat bayar terpenuhi | Sistem |
| SUDAH DIBAYARKAN | Uang telah dikeluarkan | Mba Ririn/petugas kas |
| MENUNGGU KONFIRMASI | Dibayar, penerima belum konfirmasi | Sistem |
| SUDAH DITERIMA | Penerima mengonfirmasi | Penerima |
| SIAP DISERAHKAN KE PEMBUKUAN | BKK dan bukti lengkap | Sistem |

SUDAH DIBAYARKAN tidak sama dengan SUDAH DITERIMA; keduanya wajib dibedakan.

## 9. Menu dan layar

| Menu | Fungsi | Pengguna |
|---|---|---|
| Dashboard Pencairan | Ringkasan hari ini, menunggu ACC, disetujui, jadwal besok, belum dibayar, menunggu konfirmasi | Mba Ririn, Bu Fitri |
| Input Pengajuan | Catat pengajuan langsung/berdasarkan surat; unggah lampiran | Mba Ririn |
| Register Surat Masuk | Nomor, tanggal, pengirim, perihal, lampiran, relasi ke permintaan | Mba Ririn |
| Rekap Harian | Daftar pengajuan harian; filter; kirim ke Bu Fitri | Mba Ririn |
| Persetujuan Bu Fitri | Review per baris; ACC/kembalikan/tolak; catatan | Bu Fitri |
| Jadwal Pencairan | Pengajuan ACC yang harus dibayar; kelompok per unit | Mba Ririn |
| Buat BKK | Generate BKK; nomor otomatis; preview PDF | Mba Ririn |
| Pembayaran | Input realisasi: tanggal/jam, metode, sumber kas, nominal | Mba Ririn/petugas kas |
| Konfirmasi Penerimaan | Penerima periksa nama dan nominal, lalu konfirmasi | Penerima |
| Arsip BKK | Cari BKK, akses arsip digital sesuai hak | Mba Ririn, Keuangan, Yayasan |
| Antrean Pembukuan | BKK dibayar dan diterima; hanya serah-terima | Pembukuan |

Widget dashboard: jumlah dan nominal permintaan hari ini; menunggu ACC; disetujui terjadwal besok; BKK belum dibuat; siap dibayar dan sudah dibayar; menunggu konfirmasi; sudah diterima siap diserahkan; dikembalikan/ditolak.

## 10. Model data (awal)

| Entitas | Data inti |
|---|---|
| users | user_id, nama, username, role, status |
| units | unit_id, nama_unit, status |
| requests | request_id, tanggal, sumber, pemohon, unit, NP, uraian, nominal, penerima, status |
| request_sources | source_id, tipe, nomor_surat, tanggal_surat, pengirim, perihal, file |
| request_attachments | attachment_id, request_id, file, jenis, uploaded_by |
| daily_batches | batch_id, tanggal_rekap, dibuat_oleh, status |
| approval_logs | approval_id, request_id/batch_id, approver, keputusan, waktu, catatan |
| bkk | bkk_id, nomor, request_id, unit, tahun_anggaran, NP, uraian, jumlah, tanggal, jenis |
| payments | payment_id, bkk_id, paid_by, waktu, nominal, metode, sumber_dana, status |
| receipt_confirmations | confirmation_id, bkk_id, recipient, method, confirmed_at, status |
| document_archive | archive_id, bkk_id, purpose, file_uri, access_policy |
| audit_logs | log_id, actor, action, entity, entity_id, timestamp, before_after |

Relasi: satu request punya satu sumber utama dan beberapa lampiran. Request disetujui menghasilkan BKK. BKK punya catatan pembayaran dan satu catatan konfirmasi penerimaan. Semua aktivitas penting masuk audit log. Perubahan tidak menghapus histori.

## 11. Validasi dan skenario khusus

### Validasi wajib
1. Nominal permintaan > 0.
2. Pemohon, unit, uraian, NP, nominal, penerima wajib terisi sebelum masuk rekap ACC.
3. Surat masuk minimal punya nomor/tanggal surat atau penanda dokumen sumber.
4. Satu surat dapat jadi dasar satu atau lebih permintaan; relasi harus tertelusuri.
5. Permintaan belum ACC tidak bisa dibuatkan pembayaran.
6. Nominal BKK tidak boleh berubah dari nominal disetujui tanpa alur perubahan dan persetujuan ulang.
7. SUDAH DIBAYARKAN hanya oleh Mba Ririn/petugas berwenang setelah transaksi nyata.
8. SUDAH DITERIMA hanya lewat konfirmasi penerima yang terautentikasi.
9. Penerima boleh beda dari pemohon; bila beda, identitas ditetapkan sebelum pembayaran.
10. Setelah pembayaran, perubahan data inti lewat koreksi terkontrol, bukan menimpa.

### Skenario pengecualian
| Skenario | Perilaku sistem |
|---|---|
| Permintaan tidak lengkap | Tetap draft/perlu dilengkapi; belum bisa dikirim ke Bu Fitri |
| Bu Fitri mengembalikan | Kembali ke Mba Ririn dengan catatan; versi dan histori tersimpan |
| Pembayaran tertunda | Ubah tanggal rencana + alasan; tetap belum dibayarkan |
| Penerima beda dari pemohon | Pilih penerima aktual sebelum bayar; BKK mengikuti penerima aktual |
| Penerima menolak/mengoreksi nominal | Jangan tandai diterima; tampilkan sengketa untuk ditindaklanjuti Mba Ririn |
| Salah nominal sudah dibayar | Catat kejadian, buat alur koreksi/selisih; jangan edit diam-diam |
| Pengajuan ganda | Peringatan berdasarkan pemohon, unit, tanggal, uraian, nominal, referensi surat |
| Koneksi gagal saat konfirmasi | Jangan buat status sukses sebelum server menyimpan; beri nomor bukti saat berhasil |

## 12. Keamanan dan nonfungsional

| Kebutuhan | Spesifikasi |
|---|---|
| Akses berbasis peran | Menu dan tindakan berbeda per peran |
| Autentikasi | Akun personal; ACC/pembayaran/konfirmasi terkait identitas pengguna; dilarang akun bersama |
| Audit trail | Siapa, kapan, tindakan, data sebelum/sesudah, alasan untuk perubahan sensitif |
| Penguncian dokumen | PDF final tidak ditimpa; koreksi = versi/revisi baru |
| Lampiran | Tersimpan terstruktur, ada hak akses, di-backup |
| Backup dan pemulihan | Backup terjadwal + prosedur uji pemulihan |
| Keamanan data | Enkripsi koneksi, pengamanan kredensial, batasi akses dokumen, catat unduhan |
| Responsif | Nyaman di desktop (Mba Ririn) dan ponsel/tablet (penerima) |
| Kinerja | Pencarian dan cetak BKK tidak bergantung Excel manual |
| Nomor dokumen | Nomor permintaan dan BKK unik, berurutan sesuai konfigurasi, tidak dipakai ulang |

Kebijakan dokumen:
- PDF BKK menyimpan nomor, waktu terbit, status, identitas penerima, kode verifikasi.
- Arsip Yayasan tidak otomatis terbuka untuk semua pengguna.
- Hindari penghapusan fisik data transaksi; gunakan void dengan alasan dan otorisasi.

## 13. Laporan, notifikasi, serah-terima

### Laporan
Register pengajuan; rekap permintaan harian (jumlah item dan total nominal); daftar hasil ACC; jadwal pencairan per unit; register BKK; daftar belum terkonfirmasi; arsip digital (cari menurut nomor, tanggal, unit, penerima, tahun anggaran).

### Notifikasi
- Bu Fitri: rekap harian siap diperiksa.
- Mba Ririn: Bu Fitri ACC/kembalikan/tolak; pengingat daftar pencairan besok.
- Penerima: tautan/kode konfirmasi setelah pembayaran dicatat.
- Pembukuan: BKK siap diserahkan.

### Titik serah-terima ke pembukuan
BKK sudah dibuat, pengesahan wajib terpenuhi, pembayaran tercatat, penerima mengonfirmasi, PDF dan arsip digital terbentuk.

## 14. Keputusan SOP dan default prototipe

| No | Pertanyaan | Default prototipe |
|---|---|---|
| 1 | ACC per baris atau seluruh rekap? | Tampil rekap, keputusan dan catatan per permintaan |
| 2 | Satu BKK per permintaan atau beberapa rincian? | Satu BKK per transaksi; kelompok tampil per unit |
| 3 | Pengesahan Kepala Biro sebelum atau sesudah bayar? | Langkah wajib pada BKK, SEBELUM bayar; dibuat bisa dikonfigurasi |
| 4 | "Hari berikutnya" kalender atau kerja? | H+1; admin bisa ubah dengan alasan |
| 5 | Metode pembayaran? | Field metode yang dapat dikonfigurasi (tunai, transfer) |
| 6 | Penerima tanpa akun? | Opsi kios/tablet dengan kode transaksi sekali pakai |
| 7 | Penerima selalu = pemohon? | Default dari pemohon, bisa dipilih beda sebelum bayar |
| 8 | Pembayaran sebagian? | Tidak diaktifkan |
| 9 | Yayasan terima arsip digital? | Diasumsikan ya; perlu persetujuan resmi |
| 10 | e-approval atau TTE? | e-approval terautentikasi dulu |

## 15. Urutan implementasi
1. Discovery dan validasi SOP.
2. Master dan akun (unit, NP, tahun anggaran, user, role, format nomor).
3. Pengajuan dan register surat (dua sumber, lampiran, pencarian, rekap harian).
4. ACC dan jadwal pencairan.
5. BKK dan pembayaran (generate BKK, otorisasi, pembayaran, konfirmasi).
6. Arsip dan serah-terima (cetak 1 lembar, arsip, antrean pembukuan, audit trail).
7. Uji penerimaan pengguna (normal, revisi, tolak, gagal bayar, penerima beda, gagal konfirmasi).

## 16. Kriteria penerimaan minimum
- Mba Ririn dapat mencatat pengajuan langsung dan berbasis surat masuk.
- Setiap permintaan punya ID unik dan tertelusuri ke sumber dan lampiran.
- Rekap harian dapat dikirim ke Bu Fitri; keputusan per permintaan tercatat.
- Hanya permintaan ACC yang masuk jadwal pencairan.
- BKK dihasilkan dari data permintaan dengan nomor unik.
- Pembayaran dicatat terpisah dari konfirmasi penerimaan.
- Penerima konfirmasi tanpa tanda tangan gambar, lewat autentikasi yang dapat diaudit.
- Mba Ririn dapat mencetak 1 lembar untuk pengaju.
- Arsip Keuangan dan Yayasan tersimpan digital dengan akses terbatas.
- BKK dibayar dan diterima tampil di antrean serah-terima pembukuan.
- Perubahan sensitif tidak menghapus histori dan butuh alasan/otorisasi.
