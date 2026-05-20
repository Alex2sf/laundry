<x-app-layout title="Kelola Toko">
    <x-slot:sidebar>@include('admin.partials.sidebar')</x-slot:sidebar>
    <x-slot:header>Kelola Toko Laundry</x-slot:header>
    <x-slot:subtitle>Daftar semua toko laundry yang terdaftar</x-slot:subtitle>

    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="modern-table">
                <thead><tr><th>Toko</th><th>Owner</th><th>Pengguna</th><th>Total Order</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($tenants as $tenant)
                    <tr>
                        <td>
                            <div>
                                <p class="font-semibold">{{ $tenant->name }}</p>
                                <p class="text-xs text-slate-400">{{ $tenant->phone }}</p>
                            </div>
                        </td>
                        <td>{{ $tenant->owner()?->name ?? '-' }}</td>
                        <td class="text-center">{{ $tenant->users_count }}</td>
                        <td class="text-center">{{ $tenant->orders_count }}</td>
                        <td>
                            <span class="badge {{ $tenant->isActive() ? 'badge-success' : 'badge-danger' }}">{{ ucfirst($tenant->status) }}</span>
                        </td>
                        <td class="flex items-center gap-2">
                            <a href="{{ route('admin.tenants.show', $tenant) }}" class="btn-secondary text-xs px-3 py-1">Detail</a>
                            <form method="POST" action="{{ route('admin.tenants.toggle-status', $tenant) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="{{ $tenant->isActive() ? 'btn-danger' : 'btn-success' }} text-xs px-3 py-1">
                                    {{ $tenant->isActive() ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="empty-state py-8"><p class="text-slate-400">Belum ada toko</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tenants->hasPages())
        <div class="p-4 border-t border-slate-200 dark:border-slate-700">{{ $tenants->links() }}</div>
        @endif
    </div>
</x-app-layout>
