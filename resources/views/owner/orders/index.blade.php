<x-app-layout title="Daftar Order">
    <x-slot:sidebar>@include('owner.partials.sidebar')</x-slot:sidebar>
    <x-slot:header>Daftar Order</x-slot:header>
    <x-slot:subtitle>Semua pesanan laundry toko Anda</x-slot:subtitle>

    {{-- Filters --}}
    <div class="glass-card p-4 mb-6">
        <form method="GET" class="flex flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. invoice..." class="form-input flex-1 min-w-[180px]">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input w-auto">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input w-auto">
            <select name="status" class="form-input w-auto">
                <option value="">Semua Status</option>
                <option value="antrian" {{ request('status')==='antrian'?'selected':'' }}>🕐 Antrian</option>
                <option value="proses" {{ request('status')==='proses'?'selected':'' }}>🔄 Proses</option>
                <option value="selesai" {{ request('status')==='selesai'?'selected':'' }}>✅ Selesai</option>
                <option value="diambil" {{ request('status')==='diambil'?'selected':'' }}>📦 Diambil</option>
                <option value="batal" {{ request('status')==='batal'?'selected':'' }}>❌ Batal</option>
            </select>
            <select name="payment_status" class="form-input w-auto">
                <option value="">Semua Bayar</option>
                <option value="lunas" {{ request('payment_status')==='lunas'?'selected':'' }}>Lunas</option>
                <option value="dp" {{ request('payment_status')==='dp'?'selected':'' }}>DP</option>
                <option value="belum_bayar" {{ request('payment_status')==='belum_bayar'?'selected':'' }}>Belum Bayar</option>
            </select>
            <button type="submit" class="btn-primary">Filter</button>
            <a href="{{ route('owner.orders.export', request()->query()) }}" class="btn-success">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export CSV
            </a>
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="modern-table">
                <thead><tr><th>Invoice</th><th>Waktu</th><th>Kasir</th><th>Pelanggan</th><th>Total</th><th>Bayar</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="font-mono text-sm font-semibold">{{ $order->invoice_number }}</td>
                        <td class="text-sm">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->customer->name ?? 'Umum' }}</td>
                        <td class="font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td><span class="badge {{ $order->payment_status === 'lunas' ? 'badge-success' : ($order->payment_status === 'dp' ? 'badge-warning' : 'badge-danger') }}">{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</span></td>
                        <td><span class="badge {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
                        <td>
                            <a href="{{ route('owner.orders.show', $order) }}" class="btn-secondary text-xs px-2 py-1">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8"><div class="empty-state py-8"><p class="text-slate-400">Belum ada order</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="p-4 border-t border-slate-200 dark:border-slate-700">{{ $orders->links() }}</div>
        @endif
    </div>
</x-app-layout>
