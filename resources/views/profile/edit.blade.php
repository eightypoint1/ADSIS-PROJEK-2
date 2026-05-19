@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-4">
    {{-- Edit Profile Form --}}
    <div class="bg-white" style="border:1px solid #b3c6d3;">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="font-bold text-blue-900 text-lg">Edit Profil</h2>
        </div>
        <div class="p-6">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- NIM (read-only) --}}
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                    <input type="text" value="{{ $user->nim }}" disabled
                        class="border border-gray-200 bg-gray-50 rounded px-3 py-2 w-full text-gray-500">
                </div>

                {{-- Nama --}}
                <div class="mb-3">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                        class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                        class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('email') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Jurusan --}}
                <div class="mb-3">
                    <label for="major" class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                    <input id="major" name="major" type="text" value="{{ old('major', $user->major) }}" required
                        class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('major') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Angkatan --}}
                <div class="mb-3">
                    <label for="angkatan" class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                    <input id="angkatan" name="angkatan" type="text" value="{{ old('angkatan', $user->angkatan) }}" required maxlength="4"
                        class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('angkatan') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Foto Profil --}}
                <div class="mb-3">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                    @if($user->profile_picture_path)
                    <div class="mb-2">
                        <img src="{{ Storage::disk('s3')->url($user->profile_picture_path) }}" class="w-20 h-20 object-cover border border-gray-300">
                    </div>
                    @endif
                    <input id="photo" name="photo" type="file" accept="image/jpg,image/jpeg,image/png"
                        class="border border-gray-300 rounded px-3 py-2 w-full text-sm">
                    <p class="text-xs text-gray-500 mt-1">JPG/PNG, max 2MB. Kosongkan jika tidak ingin mengganti foto.</p>
                    @error('photo') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Password Baru --}}
                <div class="mb-3">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru (opsional)</label>
                    <input id="password" name="password" type="password"
                        class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('password') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800 font-semibold">
                        Simpan
                    </button>
                    <a href="{{ route('dashboard') }}" class="border border-gray-300 px-6 py-2 rounded hover:bg-gray-50 text-gray-700">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
