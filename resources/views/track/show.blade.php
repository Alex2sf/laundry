<x-base-layout title="Status Cucian">
    <div class="min-h-screen flex items-center justify-center p-6 bg-slate-50 dark:bg-slate-900">
        <div class="w-full max-w-lg" style="animation: slideInUp 0.5s ease;">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-extrabold text-slate-800 dark:text-white">Status Cucian</h1>
                <p class="text-slate-400 font-mono">{{ $order->invoice_number }}</p>
            </div>
            <div class="glass-card p-6 space-y-4">
                {{-- Status --}}
                @php
                    $statuses = ['antrian','proses','selesai','diambil'];
                    $ci = array_search($order->status, $statuses);
                    if ($ci === false) $ci = -1;
                @endphp
                <div class="flex items-center gap-2">
                    @foreach($statuses as $i => $st)
                    <div class="flex-1 text-center">
                        <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center text-xs font-bold mb-1 {{ $i <= $ci ? 'gradient-primary text-white' : 'bg-slate-200 text-slate-400' }}">
                            @if($i < $ci) ✓ @else {{ $i+1 }} @endif
                        </div>
                        <p class="text-[10px] font-semibold {{ $i <= $ci ? 'text-sky-500' : 'text-slate-400' }}">{{ ucfirst($st) }}</p>
                    </div>
                    @if(!$loop->last)<div class="flex-1 h-1 rounded {{ $i < $ci ? 'bg-sky-400' : 'bg-slate-200' }}"></div>@endif
                    @endforeach
                </div>

                <div class="border-t pt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-400">Pelanggan</span><span class="font-semibold">{{ $order->customer->name ?? 'Umum' }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Tanggal Masuk</span><span>{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-400">Est. Selesai</span><span>{{ $order->estimated_done_at?->format('d/m/Y H:i') ?? '-' }}</span></div>
                    <div class="flex justify-between font-bold text-lg pt-2 border-t"><span>Total</span><span class="text-gradient">Rp {{ number_format($order->total,0,',','.') }}</span></div>
                    <div class="flex justify-between items-center"><span class="text-slate-400">Pembayaran</span><span class="badge {{ $order->payment_status==='lunas'?'badge-success':'badge-warning' }}">{{ ucfirst(str_replace('_',' ',$order->payment_status)) }}</span></div>
                </div>

                <div class="border-t pt-4">
                    <p class="text-xs text-slate-400 font-semibold mb-2">Daftar Layanan:</p>
                    @foreach($order->items as $item)
                    <div class="flex justify-between text-sm py-1">
                        <span>{{ $item->service_name }} ({{ $item->quantity }} {{ $item->unit }})</span>
                        <span class="font-semibold">Rp {{ number_format($item->subtotal,0,',','.') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="text-center mt-6">
                <a href="{{ route('track.index') }}" class="text-sm text-sky-500 hover:text-sky-600 font-semibold">← Lacak Invoice Lain</a>
            </div>
        </div>
    </div>
</x-base-layout>
