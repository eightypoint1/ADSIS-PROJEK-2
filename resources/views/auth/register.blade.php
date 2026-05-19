<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Nusantara Tech SIA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="background-color:#1a6496; min-height:100vh;">
    <div class="max-w-md mx-auto mt-12 bg-white rounded shadow-lg p-8">
        {{-- Header --}}
        <div class="text-center mb-6">
            <div>
                <span class="font-extrabold text-2xl text-blue-900">SIAM</span><span class="font-extrabold text-2xl text-blue-500">UB</span>
            </div>
            <p class="text-xs text-blue-900 font-semibold mt-1">SISTEM INFORMASI AKADEMIK MAHASISWA</p>
            <hr class="mt-3 border-gray-300">
        </div>

        {{-- Error List --}}
        @if($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded mb-4 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Register Form --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required
                    class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                <input id="nim" name="nim" type="text" value="{{ old('nim') }}" required
                    class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('nim') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('email') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="major" class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                <input id="major" name="major" type="text" value="{{ old('major') }}" required
                    class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('major') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="angkatan" class="block text-sm font-medium text-gray-700 mb-1">Angkatan</label>
                <input id="angkatan" name="angkatan" type="text" value="{{ old('angkatan') }}" required maxlength="4"
                    placeholder="mis. 2021"
                    class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('angkatan') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" name="password" type="password" required
                    class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @error('password') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <button type="submit" class="bg-blue-900 text-white w-full py-2 rounded hover:bg-blue-800 font-semibold">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk di sini</a>
        </p>
    </div>
</body>
</html>
