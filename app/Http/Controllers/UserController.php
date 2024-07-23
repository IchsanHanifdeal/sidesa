<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Sesuaikan dengan namespace model User
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $id_desa = auth()->user()->id_desa;
        $users = DB::table('users')->where('id_desa', $id_desa)->get();

        return view('users.index', ['users' => $users]);
    }

    public function create()
    {
        // Menampilkan form untuk membuat anggota desa baru (jika diperlukan)
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'name' => 'required',
            'nik' => 'required|unique:users',
            'no_hp' => 'nullable|unique:users',
            'alamat' => 'nullable',
            'image' => 'nullable|image|max:2048', // Max 2MB, dapat disesuaikan
            'role' => 'required|in:Admin,Warga',
            'id_desa' => 'required|exists:desa,id',
            'password' => 'required|min:6',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $fileName);
            $validatedData['image'] = $fileName;
        }

        // Simpan data anggota desa baru
        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'Anggota desa berhasil ditambahkan');
    }

    public function destroy($id)
    {
        // Hapus data anggota desa berdasarkan ID
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Anggota desa berhasil dihapus');
    }

    public function confirm($id) {
        $user = DB::table('users')->where('id', $id)->first();
        $is_confirmed = $user->is_confirmed;
        DB::table('users')->where('id', $id)->update(['is_confirmed' => !$is_confirmed]);

        return redirect()->route('users.index')->with('success', 'Anggota desa berhasil dikonfirmasi');
    }
}
