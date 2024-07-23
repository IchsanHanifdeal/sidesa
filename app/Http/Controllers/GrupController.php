<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Grup;

class GrupController extends Controller
{
    public function index()
    {
        $grups = DB::table('grup')->get();
        return view('grups.index', compact('grups'));
    }

    public function create()
    {
        return view('grups.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $idDesa = $user->id_desa;
        $idUser = $user->id;

        DB::table('grup')->insert([
            'id_desa' => $idDesa,
            'id_creator' =>  $idUser,
            'group_name' => $request->get('group_name'),
            'description' => $request->get('description'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // back
        return redirect()->back()->with('success', 'Grup berhasil dibuat');
    }

    public function edit($id)
    {
        $grup = DB::table('grup')->where('id', $id)->first();
        return view('grups.edit', compact('grup'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_desa' => 'required|exists:desa,id',
            'id_creator' => 'required|exists:users,id',
            'group_name' => 'required',
            'description' => 'nullable',
        ]);

        DB::table('grup')->where('id', $id)->update([
            'id_desa' => $validatedData['id_desa'],
            'id_creator' => $validatedData['id_creator'],
            'group_name' => $validatedData['group_name'],
            'description' => $validatedData['description'],
            'updated_at' => now(),
        ]);

        return redirect()->route('grups.index')->with('success', 'Grup berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('grup')->where('id', $id)->delete();
        return back()->with('success', 'Grup berhasil dihapus');
    }

    public function anggotaindex($id) {
        // get all anggota grup join with users table
        $anggotaGrups = DB::table('anggota_grup')
            ->join('users', 'anggota_grup.id_user', '=', 'users.id')
            ->where('anggota_grup.id_grup', $id)
            ->get();

        foreach ($anggotaGrups as $anggota) {
            if ($anggota->id_user == auth()->user()->id) {
                $anggota->isMe = true;
            } else {
                $anggota->isMe = false;
            }
        }

        $isAdminGroup = DB::table('grup')
            ->where('id', $id)
            ->where('id_creator', auth()->user()->id)
            ->exists();

        return view('posts.anggota', [
            'grup' => $id,
            'anggotaGrups' => $anggotaGrups,
            'isAdminGroup' => $isAdminGroup,
        ]);
    }

    public function anggotadestroy($id, $id_anggota)
    {
        DB::table('anggota_grup')
            ->where('id_grup', $id)
            ->where('id_user', $id_anggota)
            ->delete();

        return back()->with('success', 'Anggota berhasil dihapus');
    }

    public function anggotaaccept($id, $id_anggota)
    {
        DB::table('anggota_grup')
            ->where('id_grup', $id)
            ->where('id_user', $id_anggota)
            ->update([
                'status' => 'Accepted',
            ]);

        return back()->with('success', 'Anggota berhasil diterima');
    }
}
