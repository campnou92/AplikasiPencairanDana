<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use App\Models\ExpenseType;
use App\Models\FiscalYear;
use App\Models\Np;
use App\Models\PaymentMethod;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Units
        $units = [
            ['nama_unit' => 'Biro Administrasi Umum', 'status' => 'aktif'],
            ['nama_unit' => 'Fakultas Pertanian', 'status' => 'aktif'],
            ['nama_unit' => 'Biro Keuangan', 'status' => 'aktif'],
        ];
        foreach ($units as $unit) {
            Unit::firstOrCreate(['nama_unit' => $unit['nama_unit']], $unit);
        }

        // 2. NPs
        $nps = [
            ['kode_np' => 'NP-001', 'nama' => 'Operasional Kantor', 'status' => 'aktif'],
            ['kode_np' => 'NP-002', 'nama' => 'Praktikum & Perkuliahan', 'status' => 'aktif'],
            ['kode_np' => 'NP-003', 'nama' => 'Kegiatan Kemahasiswaan', 'status' => 'aktif'],
        ];
        foreach ($nps as $np) {
            Np::firstOrCreate(['kode_np' => $np['kode_np']], $np);
        }

        // 3. Fiscal Years
        FiscalYear::firstOrCreate(['tahun' => 2025], ['is_active' => false]);
        FiscalYear::firstOrCreate(['tahun' => 2026], ['is_active' => true]);

        // 4. Payment Methods
        $paymentMethods = [
            ['nama' => 'Tunai', 'status' => 'aktif'],
            ['nama' => 'Transfer', 'status' => 'aktif'],
        ];
        foreach ($paymentMethods as $pm) {
            PaymentMethod::firstOrCreate(['nama' => $pm['nama']], $pm);
        }

        // 5. Expense Types
        $expenseTypes = [
            ['nama' => 'Biaya', 'status' => 'aktif'],
            ['nama' => 'UM', 'status' => 'aktif'],
            ['nama' => 'Lainnya', 'status' => 'aktif'],
        ];
        foreach ($expenseTypes as $et) {
            ExpenseType::firstOrCreate(['nama' => $et['nama']], $et);
        }

        // 6. App Settings (Number formatting & counters)
        AppSetting::setValue('format_nomor_req', 'REQ/{tahun}/{urut}', 'Format nomor permintaan pengajuan dana');
        AppSetting::setValue('format_nomor_bkk', 'BKK/{tahun_anggaran}/{urut}', 'Format nomor Bukti Kas Keluar (BKK)');
        AppSetting::setValue('next_seq_req_2026', '1', 'Nomor urut permintaan pengajuan tahun 2026');
        AppSetting::setValue('next_seq_bkk_2026', '1', 'Nomor urut BKK tahun 2026');
    }
}

