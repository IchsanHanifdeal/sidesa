<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterWargaController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|unique:users|min:16|max:16',
            'no_hp' => 'required|string|unique:users',
            'alamat' => 'required|string|max:255',
            'id_desa' => 'required|exists:desa,id',
            'password' => 'required|string|min:8|confirmed',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'no_hp.unique' => 'Nomor HP sudah terdaftar',
            'nik.unique' => 'NIK sudah terdaftar',
            'nik.min' => 'Minimal NIK harus 16 karakter',
            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'longitude.numeric' => 'Longitude harus berupa angka',
            'latitude.numeric' => 'Latitude harus berupa angka',
            'image.image' => 'File yang diunggah harus berupa gambar',
            'image.mimes' => 'Format gambar yang diterima: jpeg, png, jpg',
            'image.max' => 'Ukuran gambar maksimum adalah 2MB',
        ]);

        try {
            $fileName = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images', $fileName);
            }

            DB::table('users')->insert([
                'name' => $validatedData['name'],
                'nik' => $validatedData['nik'],
                'image' => $fileName,
                'no_hp' => $validatedData['no_hp'],
                'alamat' => $validatedData['alamat'],
                'role' => 'Warga',
                'id_desa' => $validatedData['id_desa'],
                'password' => Hash::make($validatedData['password']),
                'lat' => $validatedData['latitude'],
                'long' => $validatedData['longitude'],
            ]);

            return redirect()->route('login')->with('success', 'Warga berhasil didaftarkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }
}
