<x-base-layout title="Login">
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
                <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center p-1.5 overflow-hidden shadow-md">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <h2 class="text-xl font-bold text-white tracking-wide">
                    Laundry<span class="font-normal text-cyan-200">POS</span>
                </h2>
            </div>

            {{-- Center: Hero text --}}
            <div class="relative z-10 my-auto py-12">
                <h1 class="text-5xl font-extrabold text-white leading-tight mb-6">
                    Kelola Bisnis<br>Laundry Anda<br>Lebih Mudah.
                </h1>
                <p class="text-cyan-100/80 text-lg mb-8 max-w-md">
                    Sistem manajemen laundry modern dengan pelacakan real-time, laporan otomatis, dan multi-cabang.
                </p>

                {{-- Badges --}}
                <div class="flex flex-wrap gap-3">
                    <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <svg class="w-4 h-4 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span class="text-white text-xs font-semibold">Tracking Real-time</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <svg class="w-4 h-4 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span class="text-white text-xs font-semibold">Multi-Cabang</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <svg class="w-4 h-4 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span class="text-white text-xs font-semibold">Laporan Otomatis</span>
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
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center p-1.5 overflow-hidden shadow-md">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <h1 class="text-2xl font-extrabold text-gradient">LaundryPOS</h1>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-extrabold text-slate-800 dark:text-white mb-2">Selamat datang</h2>
                    <p class="text-slate-400 text-sm">Masuk ke akun Anda untuk mengelola laundry</p>
                </div>

                @if(session('error'))
                <div class="mb-5 p-4 rounded-xl flex items-start gap-3 text-sm" style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626;">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus id="login-email"
                                   class="w-full pl-12 pr-4 py-3.5 rounded-xl border text-sm font-medium outline-none transition-all
                                          bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700
                                          text-slate-800 dark:text-slate-200 placeholder-slate-400
                                          focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                   placeholder="nama@laundry.com">
                        </div>
                    </div>

                    <div x-data="{ show: false }">
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input :type="show ? 'text' : 'password'" name="password" required id="login-password"
                                   class="w-full pl-12 pr-12 py-3.5 rounded-xl border text-sm font-medium outline-none transition-all
                                          bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700
                                          text-slate-800 dark:text-slate-200 placeholder-slate-400
                                          focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10"
                                   placeholder="••••••••">
                            <button type="button" @click="show = !show"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-sky-500 focus:ring-sky-500/20 cursor-pointer">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" id="login-submit"
                            class="w-full py-3.5 rounded-xl text-white text-sm font-bold tracking-wide transition-all duration-300 relative overflow-hidden group"
                            style="background: linear-gradient(135deg, #0ea5e9, #06b6d4); box-shadow: 0 4px 20px rgba(14,165,233,0.4);"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 30px rgba(14,165,233,0.5)'"
                            onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 20px rgba(14,165,233,0.4)'">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Masuk ke Dashboard
                        </span>
                    </button>
                </form>

                <div class="my-7 flex items-center gap-4">
                    <div class="flex-1 h-px bg-slate-200 dark:bg-slate-700"></div>
                    <span class="text-xs text-slate-400 font-medium">ATAU</span>
                    <div class="flex-1 h-px bg-slate-200 dark:bg-slate-700"></div>
                </div>

                <a href="{{ route('register') }}"
                   class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl text-sm font-bold transition-all duration-300
                          border-2 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300
                          hover:border-sky-400 hover:text-sky-600 dark:hover:text-sky-400 hover:bg-sky-50 dark:hover:bg-sky-900/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Daftar Toko Laundry — Gratis!
                </a>

                <p class="text-center text-slate-400 text-xs mt-6">
                    <a href="{{ route('track.index') }}" class="text-sky-500 hover:text-sky-600 font-semibold">🔍 Lacak Cucian Anda</a>
                </p>
            </div>
        </div>
    </div>
</x-base-layout>
