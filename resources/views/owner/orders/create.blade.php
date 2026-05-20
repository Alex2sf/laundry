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

        {{-- Custom Modal for Input Quantity --}}
        <div x-show="showQtyModal" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             style="position: fixed; inset: 0; z-index: 50; display: flex; align-items: center; justify-content: center; background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); padding: 1rem;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-cloak>
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-sm w-full shadow-2xl border border-slate-100 dark:border-slate-700/50 space-y-4"
                 style="max-width: 400px; width: 100%; border-radius: 1.5rem; background-color: #fff; margin: auto;"
                 @click.away="showQtyModal = false"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="scale-95 translate-y-4"
                 x-transition:enter-end="scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="scale-100 translate-y-0"
                 x-transition:leave-end="scale-95 translate-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 dark:bg-sky-900/20 flex items-center justify-center text-sky-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white" x-text="currentServiceName"></h3>
                        <p class="text-xs text-slate-400">Masukkan berat atau jumlah pesanan</p>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-500 dark:text-slate-400">Berat / Jumlah (<span x-text="currentServiceUnit"></span>)</label>
                    <div class="relative flex items-center">
                        <input type="number" 
                               x-model="modalQty" 
                               x-ref="qtyInput"
                               @keydown.enter.prevent="confirmAddItem()"
                               step="0.1" 
                               min="0.1" 
                               class="form-input text-2xl font-bold py-3 text-center pr-12 w-full focus:ring-2 focus:ring-sky-500 focus:border-sky-500 rounded-xl"
                               placeholder="0.0">
                        <span class="absolute right-4 font-bold text-slate-400" x-text="currentServiceUnit"></span>
                    </div>
                </div>
                
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showQtyModal = false" class="btn-secondary flex-1 py-2.5 rounded-xl text-sm font-medium">Batal</button>
                    <button type="button" @click="confirmAddItem()" class="btn-primary flex-1 py-2.5 rounded-xl text-sm font-medium">Tambahkan</button>
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

            // Modal states
            showQtyModal: false,
            currentServiceId: null,
            currentServiceName: '',
            currentServicePrice: 0,
            currentServiceUnit: '',
            modalQty: '1',

            addItem(serviceId, name, price, unit) {
                this.currentServiceId = serviceId;
                this.currentServiceName = name;
                this.currentServicePrice = price;
                this.currentServiceUnit = unit;

                const existing = this.items.find(i => i.service_id === serviceId);
                this.modalQty = existing ? existing.quantity.toString() : '1';

                this.showQtyModal = true;

                // Focus the input in the next tick
                this.$nextTick(() => {
                    this.$refs.qtyInput.focus();
                    this.$refs.qtyInput.select();
                });
            },

            confirmAddItem() {
                let qtyStr = this.modalQty.toString();
                let qty = parseFloat(qtyStr.replace(',', '.'));
                if (isNaN(qty) || qty <= 0) {
                    alert('Jumlah tidak valid!');
                    return;
                }

                const existing = this.items.find(i => i.service_id === this.currentServiceId);
                if (existing) {
                    existing.quantity = qty;
                } else {
                    this.items.push({ 
                        service_id: this.currentServiceId, 
                        name: this.currentServiceName, 
                        price: this.currentServicePrice, 
                        unit: this.currentServiceUnit, 
                        quantity: qty 
                    });
                }

                this.showQtyModal = false;
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
