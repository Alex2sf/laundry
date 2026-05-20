<x-app-layout title="Pengeluaran">
    <x-slot:sidebar>@include('owner.partials.sidebar')</x-slot:sidebar>
    <x-slot:header>Pengeluaran</x-slot:header>
    <x-slot:subtitle>Catat biaya operasional harian</x-slot:subtitle>

    <div class="glass-card p-6 mb-6" x-data="{ open: false }">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-400">Total Pengeluaran (filter aktif)</p>
                <p class="text-2xl font-extrabold text-red-500">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</p>
            </div>
            <button @click="open = !open" class="btn-primary">+ Tambah</button>
        </div>
        <form method="POST" action="{{ route('owner.expenses.store') }}" x-show="open" x-transition class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @csrf
            <div><label class="block text-sm font-semibold mb-1">Keterangan</label><input type="text" name="title" required class="form-input" placeholder="Beli deterjen"></div>
            <div><label class="block text-sm font-semibold mb-1">Jumlah (Rp)</label><input type="number" name="amount" required min="0" class="form-input" placeholder="50000"></div>
            <div><label class="block text-sm font-semibold mb-1">Kategori</label>
                <select name="category" class="form-input">
                    <option value="operasional">Operasional</option>
                    <option value="bahan">Bahan Baku</option>
                    <option value="listrik">Listrik/Air</option>
                    <option value="gaji">Gaji</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <div><label class="block text-sm font-semibold mb-1">Tanggal</label><input type="date" name="expense_date" required value="{{ date('Y-m-d') }}" class="form-input"></div>
            <div><label class="block text-sm font-semibold mb-1">Catatan</label><input type="text" name="notes" class="form-input" placeholder="Opsional"></div>
            <div class="flex items-end"><button type="submit" class="btn-success">Simpan</button></div>
        </form>
    </div>

    <div class="glass-card overflow-hidden">
        <table class="modern-table"><thead><tr><th>Tanggal</th><th>Keterangan</th><th>Kategori</th><th>Jumlah</th><th>Aksi</th></tr></thead><tbody>
        @forelse($expenses as $exp)
        <tr>
            <td class="text-sm">{{ $exp->expense_date->format('d/m/Y') }}</td>
            <td class="font-semibold">{{ $exp->title }}</td>
            <td><span class="badge badge-info">{{ ucfirst($exp->category) }}</span></td>
            <td class="font-bold text-red-500">Rp {{ number_format($exp->amount, 0, ',', '.') }}</td>
            <td><form method="POST" action="{{ route('owner.expenses.destroy', $exp) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn-danger text-xs px-2 py-1">Hapus</button></form></td>
        </tr>
        @empty
        <tr><td colspan="5"><div class="empty-state py-8"><p class="text-slate-400">Belum ada pengeluaran</p></div></td></tr>
        @endforelse
        </tbody></table>
        @if($expenses->hasPages())<div class="p-4 border-t border-slate-200 dark:border-slate-700">{{ $expenses->links() }}</div>@endif
    </div>
</x-app-layout>
