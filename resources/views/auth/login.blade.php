<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Nusantara Tech SIA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="background-color:#1a6496; min-height:100vh;">
    <div class="max-w-md mx-auto mt-24 bg-white rounded shadow-lg p-8">
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

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" name="password" type="password" required
                    class="border border-gray-300 rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <div class="mb-4 flex items-center">
                <input id="remember" name="remember" type="checkbox" class="rounded border-gray-300 text-blue-900 focus:ring-blue-400">
                <label for="remember" class="ml-2 text-sm text-gray-600">Ingat Saya</label>
            </div>
            <button type="submit" class="bg-blue-900 text-white w-full py-2 rounded hover:bg-blue-800 font-semibold">
                Masuk
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar di sini</a>
        </p>
    </div>
</body>
</html>
