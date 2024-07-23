<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Komentar;

class KomentarController extends Controller
{
    public function store(Request $request)
    {
        DB::table('komentar')->insert([
            'id_post' => $request->get('post_id'),
            'id_creator' => auth()->user()->id,
            'content' => $request->get('content'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $post = DB::table('posts')->where('id', $request->get('post_id'))->first();

        $name = auth()->user()->name;
        $content = substr($request->get('content'), 0, 20);
        $message = 'Mengomentari postingan Anda: ' . $content;

        DB::table("notification")->insert([
            'name' => $name,
            'message' => $message,
            'to' => $post->id_creator,
            'foto' => auth()->user()->image,
            'url' => '/posts/' . $request->get('post_id'),
            'read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan');
    }

    public function edit($id)
    {
        $komentar = DB::table('komentar')->where('id', $id)->first();
        return view('komentar.edit', compact('komentar'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'content' => 'required',
        ]);

        DB::table('komentar')->where('id', $id)->update([
            'content' => $validatedData['content'],
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('komentar')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Komentar berhasil dihapus');
    }
}
