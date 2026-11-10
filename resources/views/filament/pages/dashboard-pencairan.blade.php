<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Banner Informasi Tahap 1 -->
        <div class="rounded-xl border border-primary-500/20 bg-primary-50 p-5 dark:bg-primary-950/40">
            <div class="flex items-start gap-4">
                <div class="rounded-lg bg-primary-600 p-2 text-white">
                    <x-heroicon-o-information-circle class="h-6 w-6" />
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        Selamat Datang di Sistem Pengajuan dan Pencairan Dana INSTIPER (Tahap 1)
                    </h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Anda saat ini login sebagai: <span class="font-semibold text-primary-600 dark:text-primary-400">{{ auth()->user()->nama }}</span> 
                        (Peran: <code class="rounded bg-gray-200 px-1.5 py-0.5 text-xs font-mono dark:bg-gray-800">{{ auth()->user()->role }}</code>).
                    </p>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Fondasi akun, master data (Unit, NP, Tahun Anggaran, Metode Pembayaran, Jenis Pengeluaran, Format Nomor), serta pencatatan audit log telah aktif. Modul transaksi pengajuan dan pencairan akan hadir pada tahap selanjutnya.
                    </p>
                </div>
            </div>
        </div>

        <!-- Widget Placeholder Bagian 9 Blueprint -->
        <div>
            <h4 class="mb-3 text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                Ringkasan Transaksi (Placeholder Tahap 1)
            </h4>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="text-xs font-medium text-gray-500">Permintaan Hari Ini</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</span>
                        <span class="rounded bg-gray-100 px-2 py-0.5 text-xs text-gray-600 dark:bg-gray-800 dark:text-gray-400">Segera hadir</span>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="text-xs font-medium text-gray-500">Menunggu ACC (Bu Fitri)</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-2xl font-bold text-amber-600">0</span>
                        <span class="rounded bg-amber-50 px-2 py-0.5 text-xs text-amber-700 dark:bg-amber-950/50 dark:text-amber-300">Tahap 3</span>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="text-xs font-medium text-gray-500">Disetujui - Terjadwal Besok</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-2xl font-bold text-emerald-600">0</span>
                        <span class="rounded bg-emerald-50 px-2 py-0.5 text-xs text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300">Tahap 3</span>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="text-xs font-medium text-gray-500">BKK Belum Dibuat</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</span>
                        <span class="rounded bg-gray-100 px-2 py-0.5 text-xs text-gray-600 dark:bg-gray-800 dark:text-gray-400">Tahap 4</span>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="text-xs font-medium text-gray-500">Siap Dibayar / Sudah Dibayar</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-2xl font-bold text-blue-600">0</span>
                        <span class="rounded bg-blue-50 px-2 py-0.5 text-xs text-blue-700 dark:bg-blue-950/50 dark:text-blue-300">Tahap 4</span>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="text-xs font-medium text-gray-500">Menunggu Konfirmasi Penerima</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-2xl font-bold text-purple-600">0</span>
                        <span class="rounded bg-purple-50 px-2 py-0.5 text-xs text-purple-700 dark:bg-purple-950/50 dark:text-purple-300">Tahap 4</span>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="text-xs font-medium text-gray-500">Sudah Diterima (Siap Pembukuan)</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-2xl font-bold text-emerald-600">0</span>
                        <span class="rounded bg-emerald-50 px-2 py-0.5 text-xs text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300">Tahap 5</span>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <div class="text-xs font-medium text-gray-500">Dikembalikan / Ditolak</div>
                    <div class="mt-2 flex items-baseline justify-between">
                        <span class="text-2xl font-bold text-rose-600">0</span>
                        <span class="rounded bg-rose-50 px-2 py-0.5 text-xs text-rose-700 dark:bg-rose-950/50 dark:text-rose-300">Tahap 3</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>

