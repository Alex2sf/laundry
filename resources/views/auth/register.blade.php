<x-base-layout title="Daftar Toko Baru">
    <div class="min-h-screen flex">

        {{-- LEFT PANEL: Branding --}}
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-16"
             style="background: linear-gradient(135deg, #0ea5e9, #06b6d4, #0891b2);">

            {{-- Animated blobs --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-[-80px] left-[-80px] w-[400px] h-[400px] rounded-full opacity-20 blur-3xl"
                     style="background: radial-gradient(circle, #38bdf8, #06b6d4); animation: float 8s ease-in-out infinite;"></div>
                <div class="absolute bottom-[-100px] right-[-80px] w-[350px] h-[350px] rounded-full opacity-20 blur-3xl"
                     style="background: radial-gradient(circle, #22d3ee, #0ea5e9); animation: float 10s ease-in-out infinite reverse;"></div>
                {{-- Water ripple effects --}}
                <div class="absolute bottom-20 left-1/3 w-20 h-20 rounded-full border-2 border-white/10"
                     style="animation: water-ripple 3s ease-out infinite;"></div>
                <div class="absolute bottom-40 right-1/4 w-16 h-16 rounded-full border-2 border-white/10"
                     style="animation: water-ripple 4s ease-out infinite 1s;"></div>
            </div>

            {{-- Top: Logo --}}
            <div class="flex items-center gap-3 relative z-10">
                <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-white tracking-wide">
                    Laundry<span class="font-normal text-cyan-200">POS</span>
                </h2>
            </div>

            {{-- Center: Hero text --}}
            <div class="relative z-10 my-auto py-12">
                <h1 class="text-5xl font-extrabold text-white leading-tight mb-6">
                    Gabung Sekarang,<br>Kembangkan Bisnis<br>Laundry Anda.
                </h1>
                <p class="text-cyan-100/80 text-lg mb-8 max-w-md">
                    Dapatkan kemudahan pengelolaan transaksi, laporan berkala, manajemen karyawan, dan pelacakan cucian pelanggan.
                </p>

                {{-- Badges --}}
                <div class="flex flex-wrap gap-3">
                    <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <svg class="w-4 h-4 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span class="text-white text-xs font-semibold">Daftar Cepat</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <svg class="w-4 h-4 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-white text-xs font-semibold">100% Gratis</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <svg class="w-4 h-4 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span class="text-white text-xs font-semibold">Aman & Terpercaya</span>
                    </div>
                </div>
            </div>

            <div class="relative z-10 text-cyan-200/60 text-xs">
                &copy; {{ date('Y') }} LaundryPOS. Sistem Manajemen Laundry Modern.
            </div>
        </div>

        {{-- RIGHT PANEL: Form --}}
        <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-6 sm:p-12 bg-white dark:bg-slate-900 relative">

            <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                    class="absolute top-6 right-6 p-2.5 rounded-xl text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </button>

            <div class="w-full max-w-md" style="animation: slideInUp 0.5s ease;">

                {{-- Mobile logo --}}
                <div class="lg:hidden text-center mb-8 flex items-center justify-center gap-3">
                    <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <h1 class="text-2xl font-extrabold text-gradient">LaundryPOS</h1>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-extrabold text-slate-800 dark:text-white mb-2">Daftar Toko</h2>
                    <p class="text-slate-400 text-sm">Buat akun dan mulai kelola bisnis laundry Anda</p>
                </div>

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
                        <input type="text" name="store_name" value="{{ old('store_name') }}" required
                               class="w-full px-4 py-3.5 rounded-xl border text-sm font-medium outline-none transition-all
                                      bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700
                                      text-slate-800 dark:text-slate-200 placeholder-slate-400
                                      focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                               placeholder="Contoh: Laundry Bersih Kilat">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nama Pemilik</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3.5 rounded-xl border text-sm font-medium outline-none transition-all
                                          bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700
                                          text-slate-800 dark:text-slate-200 placeholder-slate-400
                                          focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                   placeholder="Nama Anda">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">No. Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3.5 rounded-xl border text-sm font-medium outline-none transition-all
                                          bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700
                                          text-slate-800 dark:text-slate-200 placeholder-slate-400
                                          focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3.5 rounded-xl border text-sm font-medium outline-none transition-all
                                      bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700
                                      text-slate-800 dark:text-slate-200 placeholder-slate-400
                                      focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                               placeholder="nama@laundry.com">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
                            <input type="password" name="password" required
                                   class="w-full px-4 py-3.5 rounded-xl border text-sm font-medium outline-none transition-all
                                          bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700
                                          text-slate-800 dark:text-slate-200 placeholder-slate-400
                                          focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                   placeholder="Min. 8 karakter">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Konfirmasi</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full px-4 py-3.5 rounded-xl border text-sm font-medium outline-none transition-all
                                          bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700
                                          text-slate-800 dark:text-slate-200 placeholder-slate-400
                                          focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                   placeholder="Ulangi password">
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

                <p class="text-center mt-6 text-sm text-slate-400">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-sky-500 font-semibold hover:text-sky-600">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</x-base-layout>
