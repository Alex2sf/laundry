<x-app-layout title="Layanan">
    <x-slot:sidebar>@include('owner.partials.sidebar')</x-slot:sidebar>
    <x-slot:header>Layanan & Harga</x-slot:header>
    <x-slot:subtitle>Atur jenis layanan dan harga laundry Anda</x-slot:subtitle>

    {{-- Add Service Form --}}
    <div class="glass-card p-6 mb-6" x-data="{ open: false }">
        <button @click="open = !open" class="btn-primary w-full sm:w-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Layanan Baru
        </button>

        <form method="POST" action="{{ route('owner.services.store') }}" x-show="open" x-transition class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-1">Nama Layanan</label>
                <input type="text" name="name" required class="form-input" placeholder="Contoh: Cuci Setrika Kiloan">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Tipe</label>
                <select name="type" class="form-input">
                    <option value="kiloan">Kiloan</option>
                    <option value="satuan">Satuan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Kecepatan</label>
                <select name="speed" class="form-input">
                    <option value="reguler">📦 Reguler (2-3 Hari)</option>
                    <option value="kilat">🔥 Kilat (24 Jam)</option>
                    <option value="express">⚡ Express (6 Jam)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Harga</label>
                <input type="number" name="price" required min="0" class="form-input" placeholder="7000">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Satuan</label>
                <select name="unit" class="form-input">
                    <option value="kg">Per Kilogram (kg)</option>
                    <option value="pcs">Per Satuan (pcs)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Estimasi (jam)</label>
                <input type="number" name="estimated_hours" required min="1" value="48" class="form-input">
            </div>
            <div class="sm:col-span-2 lg:col-span-3">
                <button type="submit" class="btn-success">Simpan Layanan</button>
            </div>
        </form>
    </div>

    {{-- Services List --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($services as $service)
        <div class="glass-card p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h4 class="font-bold text-lg">{{ $service->name }}</h4>
                    <p class="text-sm text-slate-400">{{ $service->speed_label }}</p>
                </div>
                <span class="badge {{ $service->is_active ? 'badge-success' : 'badge-danger' }}">
                    {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <div class="flex items-baseline gap-1 mb-4">
                <span class="text-2xl font-extrabold text-gradient">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                <span class="text-sm text-slate-400">/ {{ $service->unit }}</span>
            </div>
            <div class="flex items-center gap-2 text-xs mb-4">
                <span class="badge badge-info">{{ ucfirst($service->type) }}</span>
                <span class="text-slate-400">~{{ $service->estimated_hours }} jam</span>
            </div>
            <div class="flex items-center gap-2">
                <form method="POST" action="{{ route('owner.services.toggle', $service) }}">
                    @csrf @method('PATCH')
                    <button class="btn-secondary text-xs px-3 py-1">
                        {{ $service->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                <form method="POST" action="{{ route('owner.services.destroy', $service) }}" onsubmit="return confirm('Hapus layanan ini?')">
                    @csrf @method('DELETE')
                    <button class="btn-danger text-xs px-3 py-1">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="sm:col-span-2 lg:col-span-3">
            <div class="empty-state glass-card py-12">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                <p class="text-slate-400 font-semibold">Belum ada layanan</p>
                <p class="text-sm text-slate-400">Klik tombol di atas untuk menambah layanan pertama Anda</p>
            </div>
        </div>
        @endforelse
    </div>
</x-app-layout>
