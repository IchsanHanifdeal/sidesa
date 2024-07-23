<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function privateChat(Request $request, $postId) {
        $post = DB::table('posts')->where('id', $postId)->first();
        $creator = DB::table('users')->where('id', $post->id_creator)->first();

        $customMessage = "Halo, saya tertarik dengan " . $post->content . ". Bolehkah saya bertanya lebih lanjut?";
        return redirect()->away("https://wa.me/{$creator->no_hp}?text={$customMessage}");   
    }
}
