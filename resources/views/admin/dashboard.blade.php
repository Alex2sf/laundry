<x-app-layout title="Admin Dashboard">
    <x-slot:sidebar>@include('admin.partials.sidebar')</x-slot:sidebar>
    <x-slot:header>Dashboard Admin</x-slot:header>
    <x-slot:subtitle>Pantau semua toko laundry</x-slot:subtitle>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-stat-card title="Total Toko" :value="$totalTenants" from="#0ea5e9" to="#06b6d4"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>' />
        <x-stat-card title="Toko Aktif" :value="$activeTenants" from="#10b981" to="#059669"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />
        <x-stat-card title="Total Pengguna" :value="$totalUsers" from="#8b5cf6" to="#7c3aed"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>' />
        <x-stat-card title="Total Revenue" value="Rp {{ number_format($totalRevenue, 0, ',', '.') }}" from="#f59e0b" to="#d97706"
            icon='<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' />
    </div>

    {{-- Recent Tenants --}}
    <div class="glass-card overflow-hidden">
        <div class="p-4 border-b border-slate-200 dark:border-slate-700">
            <h3 class="font-bold text-lg">Toko Terdaftar Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="modern-table">
                <thead><tr><th>Nama Toko</th><th>Status</th><th>Plan</th><th>Terdaftar</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($recentTenants as $tenant)
                    <tr>
                        <td class="font-semibold">{{ $tenant->name }}</td>
                        <td><span class="badge {{ $tenant->isActive() ? 'badge-success' : 'badge-danger' }}">{{ ucfirst($tenant->status) }}</span></td>
                        <td><span class="badge badge-info">{{ ucfirst($tenant->plan) }}</span></td>
                        <td class="text-sm text-slate-400">{{ $tenant->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('admin.tenants.show', $tenant) }}" class="btn-secondary text-xs px-3 py-1">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5"><div class="empty-state py-8"><p class="text-slate-400">Belum ada toko terdaftar</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
