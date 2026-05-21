<x-app-layout title="Dashboard">
    <x-slot:sidebar>@include('owner.partials.sidebar')</x-slot:sidebar>
    <x-slot:header>Dashboard</x-slot:header>
    <x-slot:subtitle>Ringkasan bisnis laundry Anda hari ini</x-slot:subtitle>

    {{-- Stats Row 1 --}}
    <div id="tour-stats-row" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-stat-card title="Order Hari Ini" :value="$todayOrders" from="#0ea5e9" to="#06b6d4"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>' />
        <x-stat-card title="Pendapatan Hari Ini" value="Rp {{ number_format($todayRevenue, 0, ',', '.') }}" from="#10b981" to="#059669"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />
        <x-stat-card title="Sedang Diproses" :value="$pendingOrders" from="#f59e0b" to="#d97706"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />
        <x-stat-card title="Total Pelanggan" :value="$totalCustomers" from="#8b5cf6" to="#7c3aed"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>' />
    </div>

    {{-- Stats Row 2: Financial --}}
    <div id="tour-financial-stats" class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="glass-card p-5">
            <p class="text-sm text-slate-400 mb-1">💰 Pendapatan Bulan Ini</p>
            <p class="text-2xl font-extrabold text-gradient">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="glass-card p-5">
            <p class="text-sm text-slate-400 mb-1">📤 Pengeluaran Bulan Ini</p>
            <p class="text-2xl font-extrabold text-red-500">Rp {{ number_format($monthExpenses, 0, ',', '.') }}</p>
        </div>
        <div class="glass-card p-5">
            <p class="text-sm text-slate-400 mb-1">⚠️ Belum Dilunasi</p>
            <p class="text-2xl font-extrabold text-amber-500">{{ $unpaidOrders }} order</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div id="tour-quick-actions" class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('owner.orders.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Order Baru
        </a>
        <a href="{{ route('owner.orders.index') }}" class="btn-secondary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            Lihat Semua Order
        </a>
    </div>

    {{-- Chart Section --}}
    <div id="tour-chart-section" class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Revenue & Order Chart --}}
        <div class="glass-card p-6 lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-lg">Tren Pendapatan & Pesanan</h3>
                <span class="text-xs text-slate-400">7 Hari Terakhir</span>
            </div>
            <div class="relative h-72">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Order Performance Cards --}}
        <div class="glass-card p-6">
            <h3 class="font-bold text-lg mb-4">Ringkasan Performa</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Rata-rata Order / Hari</span>
                    <span class="text-base font-extrabold text-sky-500">{{ count($chartCount) > 0 ? round(array_sum($chartCount) / count($chartCount), 1) : 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Total Pendapatan (7 Hari)</span>
                    <span class="text-base font-extrabold text-emerald-500">Rp {{ number_format(array_sum($chartRevenue), 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-400">Total Transaksi (7 Hari)</span>
                    <span class="text-base font-extrabold text-violet-500">{{ array_sum($chartCount) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div id="tour-recent-orders" class="glass-card overflow-hidden">
        <div class="p-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
            <h3 class="font-bold text-lg">Order Terbaru</h3>
            <a href="{{ route('owner.orders.index') }}" class="text-sm text-sky-500 hover:text-sky-600 font-semibold">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="modern-table">
                <thead><tr><th>Invoice</th><th>Pelanggan</th><th>Total</th><th>Bayar</th><th>Status</th><th>Waktu</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="font-mono text-sm font-semibold">{{ $order->invoice_number }}</td>
                        <td>{{ $order->customer->name ?? 'Umum' }}</td>
                        <td class="font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td><span class="badge {{ $order->payment_status === 'lunas' ? 'badge-success' : ($order->payment_status === 'dp' ? 'badge-warning' : 'badge-danger') }}">{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</span></td>
                        <td><span class="badge {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                        <td class="text-sm text-slate-400">{{ $order->created_at->diffForHumans() }}</td>
                        <td><a href="{{ route('owner.orders.show', $order) }}" class="btn-secondary text-xs px-2 py-1">Detail</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="7"><div class="empty-state py-8"><p class="text-slate-400">Belum ada order hari ini</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Chart Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [
                        {
                            label: 'Pendapatan (Rp)',
                            data: {!! json_encode($chartRevenue) !!},
                            borderColor: '#0284c7',
                            backgroundColor: 'rgba(2, 132, 199, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Jumlah Order',
                            data: {!! json_encode($chartCount) !!},
                            borderColor: '#8b5cf6',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            fill: false,
                            tension: 0.1,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: '#64748b',
                                font: { family: 'Inter', weight: '600' }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#64748b' }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: { color: 'rgba(100, 116, 139, 0.1)' },
                            ticks: {
                                color: '#64748b',
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: {
                                color: '#64748b',
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>

    {{-- Onboarding Tour --}}
    @php
    $tourSteps = [
        [
            'target' => '#tour-stats-row',
            'title' => '📊 Statistik Harian',
            'description' => 'Di sini kamu bisa melihat ringkasan bisnis laundry hari ini: jumlah order masuk, pendapatan, pesanan yang sedang diproses, dan total pelanggan terdaftar.',
            'icon' => '📊',
            'iconBg' => 'linear-gradient(135deg, #0ea5e9, #06b6d4)',
            'position' => 'bottom'
        ],
        [
            'target' => '#tour-financial-stats',
            'title' => '💰 Ringkasan Keuangan Bulanan',
            'description' => 'Pantau kesehatan keuangan bisnismu! Lihat total pendapatan bulan ini, pengeluaran operasional, dan berapa order yang belum dilunasi pelanggan.',
            'icon' => '💰',
            'iconBg' => 'linear-gradient(135deg, #10b981, #059669)',
            'position' => 'bottom'
        ],
        [
            'target' => '#tour-quick-actions',
            'title' => '⚡ Aksi Cepat',
            'description' => 'Tombol pintasan untuk langsung membuat order baru atau melihat semua daftar order. Satu klik langsung kerja!',
            'icon' => '⚡',
            'iconBg' => 'linear-gradient(135deg, #f59e0b, #d97706)',
            'position' => 'bottom'
        ],
        [
            'target' => '#tour-chart-section',
            'title' => '📈 Grafik Tren & Performa',
            'description' => 'Grafik interaktif menampilkan tren pendapatan dan jumlah pesanan 7 hari terakhir. Di sampingnya ada ringkasan performa rata-rata order per hari.',
            'icon' => '📈',
            'iconBg' => 'linear-gradient(135deg, #8b5cf6, #7c3aed)',
            'position' => 'bottom'
        ],
        [
            'target' => '#tour-recent-orders',
            'title' => '🧺 Order Terbaru',
            'description' => 'Tabel ini menampilkan order-order terbaru lengkap dengan status pembayaran dan status pengerjaan. Klik Detail untuk melihat rincian setiap order.',
            'icon' => '🧺',
            'iconBg' => 'linear-gradient(135deg, #06b6d4, #0891b2)',
            'position' => 'top'
        ],
        [
            'target' => '#sidebar-order-baru',
            'title' => '➕ Buat Order Baru',
            'description' => 'Klik menu ini untuk membuat pesanan baru. Pilih pelanggan, pilih layanan, atur jumlah, dan langsung proses! Mudah banget.',
            'icon' => '➕',
            'iconBg' => 'linear-gradient(135deg, #10b981, #059669)',
            'position' => 'right'
        ],
        [
            'target' => '#sidebar-daftar-order',
            'title' => '📋 Daftar Order',
            'description' => 'Lihat semua order di sini. Kamu bisa filter berdasarkan tanggal, status pengerjaan, dan status pembayaran. Bisa juga export ke CSV!',
            'icon' => '📋',
            'iconBg' => 'linear-gradient(135deg, #3b82f6, #2563eb)',
            'position' => 'right'
        ],
        [
            'target' => '#sidebar-layanan',
            'title' => '🧴 Layanan & Harga',
            'description' => 'Atur jenis layanan laundry kamu di sini: cuci setrika, cuci kering, dll. Bisa set harga per kg atau per pcs, dan pilih kecepatan reguler/kilat/express.',
            'icon' => '🧴',
            'iconBg' => 'linear-gradient(135deg, #ec4899, #db2777)',
            'position' => 'right'
        ],
        [
            'target' => '#sidebar-pelanggan',
            'title' => '👥 Data Pelanggan',
            'description' => 'Kelola data pelanggan tetap kamu: nama, no. HP, alamat. Data pelanggan yang tersimpan akan mempercepat proses pembuatan order.',
            'icon' => '👥',
            'iconBg' => 'linear-gradient(135deg, #8b5cf6, #7c3aed)',
            'position' => 'right'
        ],
        [
            'target' => '#sidebar-pengeluaran',
            'title' => '💸 Pengeluaran',
            'description' => 'Catat semua pengeluaran operasional harian: beli deterjen, listrik, gaji karyawan, dll. Semua tercatat rapi untuk laporan keuangan!',
            'icon' => '💸',
            'iconBg' => 'linear-gradient(135deg, #ef4444, #dc2626)',
            'position' => 'right'
        ],
    ];
    @endphp
    <x-onboarding-tour tour-id="owner-dashboard" :auto-start="true" :steps="$tourSteps" />
</x-app-layout>
