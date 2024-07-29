<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $pengumuman = DB::table('pengumuman')->latest()->first();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($pengumuman && Storage::exists($pengumuman->file)) {
                Storage::delete($pengumuman->file);
            }

            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $filePath = $image->storeAs('public/images', $fileName);

            if ($pengumuman) {
                DB::table('pengumuman')->where('id', $pengumuman->id)->update(['file' => $filePath, 'updated_at' => now()]);
            } else {
                DB::table('pengumuman')->insert(['file' => $filePath, 'created_at' => now(), 'updated_at' => now()]);
            }
        }

        return redirect()->back()->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
