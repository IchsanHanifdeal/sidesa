<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {

        $tab = $request->get('tab', 'Umum');
        $idGroup = $request->get('id-group', null);

        $marketplace = $request->get('marketplace', false);

        $groups = DB::table('grup')
            ->leftJoin('anggota_grup', function ($join) {
                $join->on('grup.id', '=', 'anggota_grup.id_grup')
                    ->where('anggota_grup.id_user', auth()->user()->id);
            })
            ->join('users', 'grup.id_creator', '=', 'users.id')
            ->where('grup.id_desa', auth()->user()->id_desa)
            ->select('grup.id', 'grup.created_at','grup.group_name', 'grup.description', 'anggota_grup.status as is_member', 'grup.id_creator as id_creator', 'users.name as creator_name')
            ->orderBy('grup.created_at', 'desc')
            ->get();

        for ($i = 0; $i < count($groups); $i++) {
            $groups[$i]->is_admin = $groups[$i]->id_creator == auth()->user()->id;
            $groups[$i]->is_pending = $groups[$i]->is_member == 'Pending';
            $groups[$i]->is_member = $groups[$i]->is_member == 'Accepted';
        }

        $posts = DB::table('posts')
            ->join('users', 'posts.id_creator', '=', 'users.id')
            ->leftJoin('post_like', 'posts.id', '=', 'post_like.id_post')
            ->leftJoin('komentar', 'posts.id', '=', 'komentar.id_post')
            ->select(
                'posts.id',
                'posts.content',
                'posts.photo',
                'posts.kategori',
                'posts.for_sale',
                'posts.harga',
                'posts.stock',
                'posts.updated_at',
                'users.id as creator_id',
                'users.name as creator_name',
                'users.image as creator_image',
                DB::raw('COUNT(DISTINCT post_like.id) as like_count'),
                DB::raw('COUNT(DISTINCT komentar.id) as comment_count')
            )
            ->when($idGroup, function ($query, $idGroup) {
                return $query->where('posts.id_grup', $idGroup);
            })
            ->when($idGroup, function ($query, $idGroup) {
                return $query->where('posts.kategori', 'Grup');
            })
            ->when(!$idGroup, function ($query) {
                return $query->where('posts.kategori', 'Umum');
            })
            ->where('posts.id_desa', auth()->user()->id_desa)
            ->groupBy('posts.id', 'posts.content', 'posts.updated_at', 'users.image', 'posts.photo', 'posts.kategori', 'users.name', 'users.id', 'posts.for_sale', 'posts.harga', 'posts.stock')
            ->orderBy('posts.updated_at', 'desc')
            ->when($marketplace, function ($query) {
                return $query->where('posts.for_sale', true);
            })
            ->get();

        // check is user has already like or not
        foreach ($posts as $post) {
            $post->is_liked = DB::table('post_like')
                ->where('id_post', $post->id)
                ->where('id_user', auth()->user()->id)
                ->exists();
            $post->is_creator = $post->creator_id == auth()->user()->id;
        }

        return view('posts.index', [
            'posts' => $posts,
            'tab' => $tab,
            'idGroup' => $idGroup,
            'groups' => $groups,
        ]);
    }


    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // get from url query
        $idGroup = $request->get('idGroup');

        $user = auth()->user();

        $image = $request->file('image');
        if ($image) {
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $fileName);
        }

        DB::table('posts')->insert([
            'kategori' => $idGroup ? 'Grup' : 'Umum',
            'id_grup' => $idGroup,
            'id_desa' => $user->id_desa,
            'id_creator' => $user->id,
            'content' => $request->get('content'),
            'for_sale' => $request->get('for_sale') == 'on',
            'photo' => $fileName ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Post berhasil dibuat');
    }

    public function edit($id)
    {
        $post = DB::table('posts')->where('id', $id)->first();
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kategori' => 'required|in:Umum,Grup',
            'id_grup' => 'nullable|exists:grup,id',
            'id_desa' => 'required|exists:desa,id',
            'id_creator' => 'required|exists:users,id',
            'content' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        $post = DB::table('posts')->where('id', $id)->first();

        $photoPath = $post->photo;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos');
        }

        DB::table('posts')->where('id', $id)->update([
            'kategori' => $validatedData['kategori'],
            'id_grup' => $validatedData['id_grup'],
            'id_desa' => $validatedData['id_desa'],
            'id_creator' => $validatedData['id_creator'],
            'content' => $validatedData['content'],
            'photo' => $photoPath,
            'updated_at' => now(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('posts')->where('id', $id)->delete();
        return redirect()->route('posts.index')->with('success', 'Post berhasil dihapus');
    }

    public function show(Request $request, $id) {
        $notif_id = $request->get('notif_id');
        if ($notif_id) {
            DB::table('notification')->where('id', $notif_id)->update(['read' => 1]);
        }

        $post = DB::table('posts')
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
            ->where('posts.id', $id)
            ->groupBy('posts.id', 'posts.content', 'posts.updated_at', 'users.image', 'posts.photo', 'posts.kategori', 'users.name', 'users.id')
            ->first();

        $post->is_liked = DB::table('post_like')
            ->where('id_post', $post->id)
            ->where('id_user', auth()->user()->id)
            ->exists();


            $comments = DB::table('komentar')
            ->join('users', 'komentar.id_creator', '=', 'users.id')
            ->select('komentar.id', 'komentar.content', 'komentar.created_at', 'users.name as creator_name', 'users.image as creator_image')
            ->where('komentar.id_post', $id)
            ->orderBy('komentar.created_at', 'asc')
            ->get();


        return view('posts.show', [
            'post' => $post,
            'comments' => $comments
        ]);
    }
}
