<x-app-layout title="Pelanggan">
    <x-slot:sidebar>@include('owner.partials.sidebar')</x-slot:sidebar>
    <x-slot:header>Pelanggan</x-slot:header>
    <x-slot:subtitle>Kelola data pelanggan laundry Anda</x-slot:subtitle>

    {{-- Search + Add --}}
    <div class="flex flex-wrap items-center gap-3 mb-6">
        <form method="GET" class="flex items-center gap-3 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" class="form-input flex-1 min-w-[200px]" placeholder="Cari nama atau no. HP...">
            <button type="submit" class="btn-primary">Cari</button>
        </form>
    </div>

    {{-- Add Customer Modal --}}
    <div class="glass-card p-6 mb-6" x-data="{ open: false }">
        <button @click="open = !open" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            Tambah Pelanggan
        </button>
        <form method="POST" action="{{ route('owner.customers.store') }}" x-show="open" x-transition class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-1">Nama</label>
                <input type="text" name="name" required class="form-input" placeholder="Nama pelanggan">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">No. HP / WhatsApp</label>
                <input type="text" name="phone" class="form-input" placeholder="08xxxxxxxxxx">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Alamat</label>
                <input type="text" name="address" class="form-input" placeholder="Alamat pelanggan">
            </div>
            <div class="sm:col-span-3">
                <button type="submit" class="btn-success">Simpan Pelanggan</button>
            </div>
        </form>
    </div>

    {{-- Customers Table --}}
    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="modern-table">
                <thead><tr><th>Nama</th><th>No. HP</th><th>Alamat</th><th>Total Order</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($customers as $cust)
                    <tr>
                        <td class="font-semibold">{{ $cust->name }}</td>
                        <td class="text-sm">{{ $cust->phone ?? '-' }}</td>
                        <td class="text-sm text-slate-400">{{ Str::limit($cust->address, 40) ?? '-' }}</td>
                        <td class="text-center"><span class="badge badge-info">{{ $cust->orders_count }}</span></td>
                        <td>
                            <form method="POST" action="{{ route('owner.customers.destroy', $cust) }}" onsubmit="return confirm('Hapus pelanggan ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button class="btn-danger text-xs px-2 py-1">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5"><div class="empty-state py-8"><p class="text-slate-400">Belum ada pelanggan</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
        <div class="p-4 border-t border-slate-200 dark:border-slate-700">{{ $customers->links() }}</div>
        @endif
    </div>
</x-app-layout>
