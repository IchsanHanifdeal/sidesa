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
            'name' => 'required|string',
            'nik' => 'required|string|unique:users|min:16|max:16',
            'no_hp' => 'required|string|unique:users',
            'alamat' => 'required|string',
            'id_desa' => 'required|exists:desa,id',
            'password' => 'required|string',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
        ], [
            'nik.min' => 'Minimal NIK 16 Karakter'
        ]);

        $image = $request->file('image');
        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $fileName);

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
    }
}
