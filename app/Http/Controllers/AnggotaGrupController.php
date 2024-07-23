<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AnggotaGrup;

class AnggotaGrupController extends Controller
{
    public function index()
    {
        $anggotaGrups = DB::table('anggota_grup')->get();
        return view('anggota_grups.index', compact('anggotaGrups'));
    }

    public function create()
    {
        return view('anggota_grups.create');
    }

    public function store(Request $request)
    {
       $user = auth()->user();

        DB::table('anggota_grup')->insert([
            'id_grup' => $request->get('group_id'),
            'id_user' => $user->id,
            'status' => "Pending", // Default status "Accepted
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Berhasil bergabung dengan grup');
    }

    public function edit($id)
    {
        $anggotaGrup = DB::table('anggota_grup')->where('id', $id)->first();
        return view('anggota_grups.edit', compact('anggotaGrup'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_grup' => 'required|exists:grup,id',
            'id_user' => 'required|exists:users,id',
            'status' => 'required|in:Pending,Accepted,Rejected',
        ]);

        DB::table('anggota_grup')->where('id', $id)->update([
            'id_grup' => $validatedData['id_grup'],
            'id_user' => $validatedData['id_user'],
            'status' => $validatedData['status'],
            'updated_at' => now(),
        ]);

        return redirect()->route('anggota_grups.index')->with('success', 'Anggota grup berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('anggota_grup')
        ->where('id_grup', $id)
        ->where('id_user', auth()->user()->id)
        ->delete();


        return back()->with('success', 'Anggota grup berhasil dihapus');
    }
}
