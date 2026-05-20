<x-app-layout title="Buat Order Baru">
    <x-slot:sidebar>@include('owner.partials.sidebar')</x-slot:sidebar>
    <x-slot:header>🧺 Buat Order Baru</x-slot:header>
    <x-slot:subtitle>Input pesanan laundry pelanggan</x-slot:subtitle>

    <form method="POST" action="{{ route('owner.orders.store') }}" x-data="orderForm()" @submit.prevent="submitOrder">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Service Selection --}}
            <div class="lg:col-span-2 space-y-4">
                {{-- Customer --}}
                <div class="glass-card p-5">
                    <h3 class="font-bold mb-3">👤 Pelanggan</h3>
                    <select name="customer_id" class="form-input">
                        <option value="">Umum (Walk-in)</option>
                        @foreach($customers as $cust)
                            <option value="{{ $cust->id }}">{{ $cust->name }} {{ $cust->phone ? '- '.$cust->phone : '' }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Services --}}
                <div class="glass-card p-5">
                    <h3 class="font-bold mb-3">🧴 Pilih Layanan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($services as $service)
                        <button type="button" @click="addItem({{ $service->id }}, '{{ addslashes($service->name) }} ({{ ucfirst($service->speed) }})', {{ $service->price }}, '{{ $service->unit }}')"
                                class="order-card text-left hover:scale-[1.02] active:scale-[0.98] transition-transform">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold">{{ $service->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $service->speed_label }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-sky-500">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-slate-400">/ {{ $service->unit }}</p>
                                </div>
                            </div>
                        </button>
                        @endforeach
                    </div>
                    @if($services->isEmpty())
                    <p class="text-center text-slate-400 py-6">Belum ada layanan. <a href="{{ route('owner.services.index') }}" class="text-sky-500 font-semibold">Tambah layanan dulu →</a></p>
                    @endif
                </div>
            </div>

            {{-- Right: Order Summary --}}
            <div class="space-y-4">
                <div class="glass-card p-5 sticky top-24">
                    <h3 class="font-bold mb-4">🧾 Ringkasan Order</h3>

                    {{-- Items --}}
                    <div class="space-y-3 mb-4 max-h-60 overflow-y-auto">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-700/50">
                                <input type="hidden" :name="'items['+index+'][service_id]'" :value="item.service_id">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold truncate" x-text="item.name"></p>
                                    <p class="text-xs text-slate-400">Rp <span x-text="numberFormat(item.price)"></span> / <span x-text="item.unit"></span></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="item.quantity = Math.max(0.5, item.quantity - 0.5)" class="w-7 h-7 rounded-lg bg-slate-200 dark:bg-slate-600 flex items-center justify-center text-sm font-bold">-</button>
                                    <input type="number" :name="'items['+index+'][quantity]'" x-model.number="item.quantity" step="0.5" min="0.5" class="w-16 text-center form-input text-sm py-1">
                                    <button type="button" @click="item.quantity += 0.5" class="w-7 h-7 rounded-lg bg-sky-100 dark:bg-sky-900/30 text-sky-600 flex items-center justify-center text-sm font-bold">+</button>
                                </div>
                                <button type="button" @click="items.splice(index, 1)" class="text-red-400 hover:text-red-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </template>
                        <p x-show="items.length === 0" class="text-center text-slate-400 text-sm py-4">Klik layanan untuk menambahkan</p>
                    </div>

                    {{-- Totals --}}
                    <div class="border-t border-slate-200 dark:border-slate-700 pt-4 space-y-2">
                        <div class="flex justify-between text-lg font-extrabold">
                            <span>Total</span>
                            <span class="text-gradient">Rp <span x-text="numberFormat(grandTotal)"></span></span>
                        </div>
                    </div>

                    {{-- Payment --}}
                    <div class="border-t border-slate-200 dark:border-slate-700 pt-4 mt-4 space-y-3">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Metode Bayar</label>
                            <select name="payment_method" class="form-input">
                                <option value="cash">💵 Cash</option>
                                <option value="qris">📱 QRIS</option>
                                <option value="transfer">🏦 Transfer</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Status Bayar</label>
                            <select name="payment_status" x-model="paymentStatus" class="form-input">
                                <option value="lunas">💰 Lunas</option>
                                <option value="dp">💳 DP (Uang Muka)</option>
                                <option value="belum_bayar">⏳ Bayar Nanti</option>
                            </select>
                        </div>
                        <div x-show="paymentStatus !== 'belum_bayar'">
                            <label class="block text-sm font-semibold mb-1">Jumlah Bayar</label>
                            <input type="number" name="paid_amount" x-model.number="paidAmount" class="form-input" placeholder="0">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Catatan</label>
                            <textarea name="notes" rows="2" class="form-input" placeholder="Catatan khusus..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary w-full mt-4" :disabled="items.length === 0"
                            :class="{ 'opacity-50 cursor-not-allowed': items.length === 0 }">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Proses Order
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
    function orderForm() {
        return {
            items: [],
            paymentStatus: 'lunas',
            paidAmount: 0,

            addItem(serviceId, name, price, unit) {
                let defaultQty = 1;
                const existing = this.items.find(i => i.service_id === serviceId);
                if (existing) {
                    defaultQty = existing.quantity;
                }

                let qty = prompt(`Masukkan berat/jumlah (${unit}) untuk ${name}:`, defaultQty);
                if (qty === null) return;

                qty = parseFloat(qty.replace(',', '.'));
                if (isNaN(qty) || qty <= 0) {
                    alert('Jumlah tidak valid!');
                    return;
                }

                if (existing) {
                    existing.quantity = qty;
                } else {
                    this.items.push({ service_id: serviceId, name, price, unit, quantity: qty });
                }
            },

            get grandTotal() {
                return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            },

            numberFormat(num) {
                return new Intl.NumberFormat('id-ID').format(num);
            },

            submitOrder() {
                if (this.items.length === 0) return;
                this.$el.submit();
            }
        }
    }
    </script>
</x-app-layout>
