<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    public function like(Request $request, $postId)
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login
        $post = DB::table('posts')->where('id', $postId)->first();

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        // Cek apakah user sudah menyukai post ini sebelumnya
        $existingLike = DB::table('post_like')->where('id_post', $postId)->where('id_user', $user->id)->first();
        $liked = true;

        if ($existingLike) {
            // Jika sudah ada like sebelumnya, hapus like tersebut
            DB::table('post_like')->where('id', $existingLike->id)->delete();
            $liked = false;
        } else {
            // Jika belum ada like sebelumnya, buat like baru
            DB::table('post_like')->insert([
                'id_post' => $postId,
                'id_user' => $user->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Hitung total jumlah like untuk post ini
        $likeCount = DB::table('post_like')->where('id_post', $postId)->count();
        return response()->json(['like_count' => $likeCount, 'liked' => $liked]);
    }
}
