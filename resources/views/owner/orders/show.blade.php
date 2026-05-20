<x-app-layout title="Detail Order">
    <x-slot:sidebar>@include('owner.partials.sidebar')</x-slot:sidebar>
    <x-slot:header>Detail Order</x-slot:header>
    <x-slot:subtitle>{{ $order->invoice_number }}</x-slot:subtitle>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            {{-- Status --}}
            <div class="glass-card p-6">
                <h3 class="font-bold mb-4">📊 Status Pesanan</h3>
                @php
                    $statuses = ['antrian','proses','selesai','diambil'];
                    $ci = array_search($order->status, $statuses);
                    if ($ci === false) $ci = -1;
                @endphp
                <div class="flex items-center gap-2 mb-4">
                    @foreach($statuses as $i => $st)
                    <div class="flex-1 text-center">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center text-sm font-bold mb-2 {{ $i <= $ci ? 'gradient-primary text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-400' }}">
                            @if($i < $ci) ✓ @else {{ $i+1 }} @endif
                        </div>
                        <p class="text-xs font-semibold {{ $i <= $ci ? 'text-sky-500' : 'text-slate-400' }}">{{ ucfirst($st) }}</p>
                    </div>
                    @if(!$loop->last)<div class="flex-1 h-1 rounded {{ $i < $ci ? 'bg-sky-400' : 'bg-slate-200 dark:bg-slate-700' }}"></div>@endif
                    @endforeach
                </div>
                @if(!in_array($order->status, ['diambil','batal']))
                <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                    @php $next = match($order->status) { 'antrian'=>['proses'=>'🔄 Proses','batal'=>'❌ Batal'], 'proses'=>['selesai'=>'✅ Selesai','batal'=>'❌ Batal'], 'selesai'=>['diambil'=>'📦 Diambil'], default=>[] }; @endphp
                    @foreach($next as $s => $l)
                    <form method="POST" action="{{ route('owner.orders.update-status', $order) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="{{ $s }}"><button class="{{ $s==='batal'?'btn-danger':'btn-primary' }} text-sm">{{ $l }}</button></form>
                    @endforeach
                </div>
                @endif
            </div>
            {{-- Items --}}
            <div class="glass-card overflow-hidden">
                <div class="p-4 border-b border-slate-200 dark:border-slate-700"><h3 class="font-bold">🧴 Detail Layanan</h3></div>
                <table class="modern-table"><thead><tr><th>Layanan</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr></thead><tbody>
                @foreach($order->items as $item)
                <tr><td class="font-semibold">{{ $item->service_name }}</td><td>Rp {{ number_format($item->price,0,',','.') }}/{{ $item->unit }}</td><td>{{ $item->quantity }} {{ $item->unit }}</td><td class="font-bold">Rp {{ number_format($item->subtotal,0,',','.') }}</td></tr>
                @endforeach
                </tbody></table>
            </div>
        </div>
        <div class="space-y-4">
            <div class="glass-card p-5">
                <h3 class="font-bold mb-3">📋 Info</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-400">Pelanggan</span><span class="font-semibold">{{ $order->customer->name ?? 'Umum' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Kasir</span><span>{{ $order->user->name }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Tanggal</span><span>{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Est. Selesai</span><span>{{ $order->estimated_done_at?->format('d/m/Y H:i') ?? '-' }}</span></div>
                    @if($order->notes)<p class="pt-2 border-t border-slate-200 dark:border-slate-700 text-slate-400">{{ $order->notes }}</p>@endif
                </div>
            </div>
            <div class="glass-card p-5">
                <h3 class="font-bold mb-3">💰 Bayar</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between font-extrabold text-lg"><span>Total</span><span class="text-gradient">Rp {{ number_format($order->total,0,',','.') }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Dibayar</span><span>Rp {{ number_format($order->paid_amount,0,',','.') }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Kembalian</span><span>Rp {{ number_format($order->change_amount,0,',','.') }}</span></div>
                    <div class="flex justify-between items-center pt-2"><span class="text-slate-400">Status</span><span class="badge {{ $order->payment_status==='lunas'?'badge-success':($order->payment_status==='dp'?'badge-warning':'badge-danger') }}">{{ ucfirst(str_replace('_',' ',$order->payment_status)) }}</span></div>
                    <div class="flex justify-between items-center"><span class="text-slate-400">Metode</span><span class="badge badge-info">{{ strtoupper($order->payment_method) }}</span></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
