<x-base-layout title="Daftar Toko Baru">
    <div class="min-h-screen flex items-center justify-center p-6 bg-slate-50 dark:bg-slate-900 relative overflow-hidden">

        {{-- Background decorations --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle, #0ea5e9, #06b6d4);"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full blur-3xl opacity-10" style="background: radial-gradient(circle, #22d3ee, #0ea5e9);"></div>
        </div>

        <div class="w-full max-w-lg relative z-10" style="animation: slideInUp 0.5s ease;">
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl gradient-primary flex items-center justify-center mx-auto mb-4">
                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-800 dark:text-white">Daftar Toko Laundry</h1>
                <p class="text-slate-400 mt-2">Buat akun dan mulai kelola bisnis laundry Anda</p>
            </div>

            <div class="glass-card p-8">
                @if($errors->any())
                <div class="mb-5 p-4 rounded-xl text-sm" style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626;">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nama Toko Laundry</label>
                        <input type="text" name="store_name" value="{{ old('store_name') }}" required class="form-input" placeholder="Contoh: Laundry Bersih Kilat">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nama Pemilik</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="Nama Anda">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">No. Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="nama@laundry.com">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
                            <input type="password" name="password" required class="form-input" placeholder="Min. 8 karakter">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Konfirmasi</label>
                            <input type="password" name="password_confirmation" required class="form-input" placeholder="Ulangi password">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full py-3.5 rounded-xl text-white text-sm font-bold tracking-wide transition-all duration-300"
                            style="background: linear-gradient(135deg, #0ea5e9, #06b6d4); box-shadow: 0 4px 20px rgba(14,165,233,0.4);"
                            onmouseover="this.style.transform='translateY(-2px)'"
                            onmouseout="this.style.transform=''">
                        🚀 Daftarkan Toko Saya
                    </button>
                </form>
            </div>

            <p class="text-center mt-6 text-sm text-slate-400">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-sky-500 font-semibold hover:text-sky-600">Masuk di sini</a>
            </p>
        </div>
    </div>
</x-base-layout>
