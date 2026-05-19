@extends('layouts.app')

@section('content')
<div class="flex gap-4">
    {{-- Left Column: Profile Card + Announcements --}}
    <div class="flex-grow space-y-4">
        {{-- Profile Card --}}
        <div class="bg-white" style="border:1px solid #b3c6d3;">
            <div class="flex p-4">
                {{-- Photo Box --}}
                <div class="flex-shrink-0" style="width:120px;">
                    <div style="width:120px; height:120px; border:2px solid #2980b9; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                        @if($user->profile_picture_path)
                        <img src="{{ Storage::disk('s3')->url($user->profile_picture_path) }}" class="w-full h-full object-cover" alt="Foto Profil">
                        @else
                        <svg viewBox="0 0 100 100" class="w-full h-full" fill="#9ca3af" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="35" r="20"/>
                            <ellipse cx="50" cy="95" rx="35" ry="25"/>
                        </svg>
                        @endif
                    </div>
                </div>

                {{-- Info Column --}}
                <div class="ml-4 flex-grow space-y-1">
                    <div class="text-sm font-mono" style="color:#2980b9;">{{ $user->nim }}</div>
                    <div class="font-bold text-gray-900 text-lg">{{ $user->name }}</div>
                    <div class="text-sm text-gray-700">Jenjang/Fakultas &rsaquo; S1/Ilmu Komputer</div>
                    <div class="text-sm text-gray-700">Jurusan &rsaquo; {{ $user->major }}</div>
                    <div class="text-sm text-gray-700">Program Studi &rsaquo; {{ $user->major }}</div>
                    <div class="text-sm text-gray-700">Angkatan &rsaquo; {{ $user->angkatan }}</div>
                    <div class="text-sm text-gray-700">
                        Status : <span class="font-extrabold" style="color:#1e8449;">AKTIF</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Announcement Banners --}}
        <div style="background:#d4efdf; border-left:4px solid #1e8449; padding:12px 16px;">
            <p class="text-sm" style="color:#1e8449;">
                Anda sudah mempunyai account email dengan alamat : <strong>{{ $user->email }}</strong>. Untuk masuk ke email mahasiswa, silahkan buka sistem email universitas.
            </p>
        </div>

        <div style="background:#e8daef; border-left:4px solid #6c3483; padding:12px 16px;">
            <p class="text-sm" style="color:#6c3483;">
                Selamat datang di Sistem Informasi Akademik Nusantara Tech. Pastikan data profil Anda selalu diperbarui.
            </p>
        </div>
    </div>

    {{-- Right Sidebar Menu --}}
    <div class="flex-shrink-0 bg-white" style="width:220px; border:1px solid #b3c6d3;">
        {{-- EDIT PROFIL --}}
        <a href="{{ route('profile.edit') }}" class="block border-b border-gray-200 px-4 py-3 hover:bg-blue-50 no-underline text-inherit">
            <div class="flex items-start gap-2">
                <span class="text-blue-800 font-bold">&blacktriangleright;</span>
                <div>
                    <div class="font-bold text-blue-900 text-sm uppercase tracking-wide">EDIT PROFIL</div>
                    <div class="text-gray-500 text-xs italic">Edit Profile</div>
                </div>
            </div>
        </a>

        {{-- HAPUS AKUN with Alpine.js Modal --}}
        <div x-data="{ confirmDelete: false }">
            <button @click="confirmDelete = true" class="flex items-start gap-2 px-4 py-3 w-full text-left bg-transparent border-none cursor-pointer hover:bg-blue-50">
                <span class="text-red-600 font-bold">&blacktriangleright;</span>
                <div>
                    <div class="font-bold text-red-600 text-sm uppercase tracking-wide">HAPUS AKUN</div>
                    <div class="text-gray-500 text-xs italic">Delete Account</div>
                </div>
            </button>

            {{-- Modal Overlay --}}
            <div x-show="confirmDelete" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
                <div class="bg-white p-6 rounded shadow-lg max-w-sm w-full mx-4" @click.outside="confirmDelete = false">
                    <h3 class="font-bold text-red-700 text-lg mb-2">Hapus Akun</h3>
                    <p class="text-gray-700 text-sm mb-4">Tindakan ini tidak dapat dibatalkan. Akun dan semua data Anda akan dihapus permanen.</p>
                    <div class="flex gap-3">
                        <form action="{{ route('profile.destroy') }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white w-full py-2 rounded hover:bg-red-700">Ya, Hapus Akun</button>
                        </form>
                        <button @click="confirmDelete = false" class="flex-1 border border-gray-300 py-2 rounded hover:bg-gray-50">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
