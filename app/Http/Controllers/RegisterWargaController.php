<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterWargaController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'nik' => 'required|string|unique:users|min:16|max:16',
            'no_hp' => 'required|string|unique:users',
            'alamat' => 'required|string',
            'id_desa' => 'required|exists:desa,id',
            'password' => 'required|string',
        ]);


        $image = $request->file('image');
        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $fileName);

        DB::table('users')->insert([
            'name' => $request->name,
            'nik' => $request->nik,
            'image' => $fileName,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => 'Warga',
            'id_desa' => $request->id_desa,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Warga berhasil didaftarkan');
    }
}
