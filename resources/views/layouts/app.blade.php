<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAMUB — Nusantara Tech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { background-color: #1a6496; min-height: 100vh; }
    </style>
</head>
<body>
    {{-- Top Navigation Bar --}}
    <nav class="bg-white border-b border-gray-300">
        <div class="flex justify-between items-center px-6 py-3">
            {{-- Left: Logo --}}
            <div class="flex flex-col leading-tight">
                <div>
                    <span class="font-extrabold text-2xl text-blue-900">SIAM</span><span class="font-extrabold text-2xl text-blue-500">UB</span>
                </div>
                <span class="text-blue-900 font-semibold tracking-wide" style="font-size:0.6rem; line-height:1;">SISTEM INFORMASI AKADEMIK MAHASISWA</span>
                <span class="text-blue-900 font-semibold tracking-wide" style="font-size:0.6rem; line-height:1;">UNIVERSITAS BRAWIJAYA</span>
            </div>

            {{-- Right: Icon Navigation --}}
            <div class="flex items-center gap-1">
                {{-- AKADEMIK --}}
                <div class="flex flex-col items-center px-3 border-r border-gray-300">
                    <svg class="w-5 h-5 text-blue-800" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/></svg>
                    <span class="text-xs text-blue-800 font-semibold mt-1">AKADEMIK</span>
                </div>
                {{-- BIODATA --}}
                <div class="flex flex-col items-center px-3 border-r border-gray-300">
                    <svg class="w-5 h-5 text-blue-800" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v1.2h19.2v-1.2c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                    <span class="text-xs text-blue-800 font-semibold mt-1">BIODATA</span>
                </div>
                {{-- KELUAR --}}
                <div class="flex flex-col items-center px-3">
                    <form method="POST" action="{{ route('logout') }}" class="flex flex-col items-center">
                        @csrf
                        <button type="submit" class="flex flex-col items-center cursor-pointer bg-transparent border-none p-0">
                            <svg class="w-5 h-5 text-blue-800" fill="currentColor" viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                            <span class="text-xs text-blue-800 font-semibold mt-1">KELUAR</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="max-w-5xl mx-auto mt-4 px-4">
        <div class="px-4 py-3 text-sm font-medium" style="background:#d4efdf; border-left:4px solid #1e8449; color:#1e8449;">
            {{ session('success') }}
        </div>
    </div>
    @endif

    {{-- Content Area --}}
    <div class="max-w-5xl mx-auto py-6 px-4">
        @yield('content')
    </div>
</body>
</html>
