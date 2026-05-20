<x-app-layout title="Dashboard">
    <x-slot:sidebar>@include('owner.partials.sidebar')</x-slot:sidebar>
    <x-slot:header>Dashboard</x-slot:header>
    <x-slot:subtitle>Ringkasan bisnis laundry Anda hari ini</x-slot:subtitle>

    {{-- Stats Row 1 --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
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
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
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
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('owner.orders.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Order Baru
        </a>
        <a href="{{ route('owner.orders.index') }}" class="btn-secondary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            Lihat Semua Order
        </a>
    </div>

    {{-- Recent Orders --}}
    <div class="glass-card overflow-hidden">
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
</x-app-layout>
