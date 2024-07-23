<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function show($id) {
        $user = DB::table('users')
        ->join('desa', 'users.id_desa', '=', 'desa.id')
        ->where('users.id', $id)
        ->first();

        $posts = DB::table('posts')
            ->join('users', 'posts.id_creator', '=', 'users.id')
            ->leftJoin('post_like', 'posts.id', '=', 'post_like.id_post')
            ->leftJoin('komentar', 'posts.id', '=', 'komentar.id_post')
            ->select(
                'posts.id',
                'posts.content',
                'posts.photo',
                'posts.kategori',
                'posts.updated_at',
                'users.id as creator_id',
                'users.name as creator_name',
                'users.image as creator_image',
                DB::raw('COUNT(DISTINCT post_like.id) as like_count'),
                DB::raw('COUNT(DISTINCT komentar.id) as comment_count')
            )
            ->where('posts.id_desa', auth()->user()->id_desa)
            ->where('posts.id_grup', null)
            ->where('posts.id_creator', $id)
            ->groupBy('posts.id', 'posts.content', 'posts.updated_at', 'users.image', 'posts.photo', 'posts.kategori', 'users.name', 'users.id')
            ->orderBy('posts.updated_at', 'desc')
            ->get();

        // check is user has already like or not
        foreach ($posts as $post) {
            $post->is_liked = DB::table('post_like')
                ->where('id_post', $post->id)
                ->where('id_user', auth()->user()->id)
                ->exists();
            $post->is_creator = $post->creator_id == auth()->user()->id;
        }

        return view('profile.show', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $name = $request->input('name');
        $nik = $request->input('nik');
        $no_hp = $request->input('no_hp');
        $alamat = $request->input('alamat');
        $image = $request->file('image');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        // Jalankan Query Builder
        DB::table('users')
            ->where('id', auth()->user()->id)
            ->update([
                'name' => $name,
                'nik' => $nik,
                'no_hp' => $no_hp,
                'alamat' => $alamat,
                'lat' => $latitude,
                'long' => $longitude
            ]);

        // Jika ada file gambar yang diunggah, simpan gambar
        if ($image) {
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/images', $imageName);

            DB::table('users')
                ->where('id', auth()->user()->id)
                ->update(['image' => $imageName]);
        }

        return Redirect::back();

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
