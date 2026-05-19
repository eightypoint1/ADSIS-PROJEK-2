<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => auth()->user()]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'major'    => 'required|string|max:255',
            'angkatan' => 'required|string|size:4',
            'password' => 'nullable|string|min:8|confirmed',
            'photo'    => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'major', 'angkatan']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($user->profile_picture_path) {
                Storage::disk('s3')->delete($user->profile_picture_path);
            }
            $data['profile_picture_path'] = $request->file('photo')->store('avatars', 's3');
        }

        $user->update($data);

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    public function destroy(Request $request)
    {
        $user = auth()->user();
        if ($user->profile_picture_path) {
            Storage::disk('s3')->delete($user->profile_picture_path);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $user->delete();
        return redirect('/')->with('success', 'Akun Anda telah dihapus.');
    }
}
