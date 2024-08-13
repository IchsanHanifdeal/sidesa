<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('galeri.index', [
            'galeri' => DB::table('galeri')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('galeri.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'foto' => 'required',
            'keterangan' => 'required',
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fileName = uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/images', $fileName);
        } else {
            $fileName = null;
        }

        // Menyimpan data grup baru
        $galeri = DB::table('galeri')->insertGetId([
            'tanggal_upload' => now(),
            'id_desa' => auth()->user()->id_desa,
            'keterangan' => $request->get('keterangan'),
            'gambar' => $fileName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('galeri')->with('success', 'Galeri berhasil dibuat');
    }

    public function destroy($id)
    {
        $item = DB::table('galeri')->where('id', $id)->first();

        if ($item) {
            if ($item->gambar) {
                Storage::disk('public')->delete('images/' . $item->gambar);
            }

            DB::table('galeri')->where('id', $id)->delete();

            return redirect()->route('galeri')->with('success', 'Galeri berhasil dihapus');
        }

        return redirect()->route('galeri')->with('error', 'Galeri tidak ditemukan');
    }
}
