<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'LaundryPOS' }} - Sistem Manajemen Laundry</title>
    <meta name="description" content="Sistem POS & Manajemen Laundry Modern Multi-Tenant">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 antialiased">
    {{ $slot }}

    {{-- Toast Notifications --}}
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => showToast("{{ session('success') }}", 'success'));
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => showToast("{{ session('error') }}", 'error'));
    </script>
    @endif
</body>
</html>
