<x-app-layout title="Detail Toko">
    <x-slot:sidebar>@include('admin.partials.sidebar')</x-slot:sidebar>
    <x-slot:header>{{ $tenant->name }}</x-slot:header>
    <x-slot:subtitle>Detail informasi toko</x-slot:subtitle>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-stat-card title="Total Order" :value="$tenant->orders_count" from="#0ea5e9" to="#06b6d4" icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>' />
        <x-stat-card title="Pelanggan" :value="$tenant->customers_count" from="#10b981" to="#059669" icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>' />
        <x-stat-card title="Layanan" :value="$tenant->services_count" from="#8b5cf6" to="#7c3aed" icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>' />
        <x-stat-card title="Pengguna" :value="$tenant->users_count" from="#f59e0b" to="#d97706" icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>' />
    </div>

    {{-- Info --}}
    <div class="glass-card p-6 mb-6">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><span class="text-slate-400">Email:</span> <span class="font-semibold">{{ $tenant->email ?? '-' }}</span></div>
            <div><span class="text-slate-400">Telepon:</span> <span class="font-semibold">{{ $tenant->phone ?? '-' }}</span></div>
            <div><span class="text-slate-400">Alamat:</span> <span class="font-semibold">{{ $tenant->address ?? '-' }}</span></div>
            <div><span class="text-slate-400">Status:</span> <span class="badge {{ $tenant->isActive() ? 'badge-success' : 'badge-danger' }}">{{ ucfirst($tenant->status) }}</span></div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="glass-card overflow-hidden">
        <div class="p-4 border-b border-slate-200 dark:border-slate-700"><h3 class="font-bold">Order Terakhir</h3></div>
        <div class="overflow-x-auto">
            <table class="modern-table">
                <thead><tr><th>Invoice</th><th>Pelanggan</th><th>Total</th><th>Status</th><th>Waktu</th></tr></thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="font-mono text-sm font-semibold">{{ $order->invoice_number }}</td>
                        <td>{{ $order->customer->name ?? 'Umum' }}</td>
                        <td class="font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td><span class="badge {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                        <td class="text-sm text-slate-400">{{ $order->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-slate-400 py-6">Belum ada order</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
