<x-base-layout title="Lacak Cucian">
    <div class="min-h-screen flex items-center justify-center p-6 bg-slate-50 dark:bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] rounded-full blur-3xl opacity-5" style="background: radial-gradient(circle, #0ea5e9, #06b6d4);"></div>
        </div>
        <div class="w-full max-w-md relative z-10 text-center" style="animation: slideInUp 0.5s ease;">
            <div class="w-20 h-20 rounded-2xl gradient-primary flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-800 dark:text-white mb-2">Lacak Cucian Anda</h1>
            <p class="text-slate-400 mb-8">Masukkan nomor invoice untuk cek status cucian</p>

            @if(session('error'))
            <div class="mb-4 p-3 rounded-xl text-sm text-red-600 bg-red-50 border border-red-200">{{ session('error') }}</div>
            @endif

            <form action="{{ route('track.show', '') }}" onsubmit="event.preventDefault(); window.location = this.action + '/' + this.invoice.value;" class="glass-card p-6">
                <input type="text" name="invoice" required class="form-input text-center text-lg font-mono mb-4" placeholder="LDR-1-20260520-0001">
                <button type="submit" class="btn-primary w-full">🔍 Lacak Sekarang</button>
            </form>

            <a href="{{ route('login') }}" class="inline-block mt-6 text-sm text-sky-500 hover:text-sky-600 font-semibold">← Kembali ke Login</a>
        </div>
    </div>
</x-base-layout>
