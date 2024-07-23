<?php

use App\Http\Controllers\AnggotaGrupController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GrupController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterWargaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::post("/register-warga", [RegisterWargaController::class, 'store'])->name('register-warga.store');

Route::get('/register-warga', function () {
    $daftarDesa = DB::table('desa')->get();
    return view('auth.register-warga', [
        'daftarDesa' => $daftarDesa,
    ]);
})->name('register-warga');

Route::get('/dashboard', function () {
    $id_desa = auth()->user()->id_desa;

    $anggotaDesa = DB::table('users')->where('id_desa', $id_desa)->get();

    return view('dashboard', [
        'anggotaDesa' => $anggotaDesa,
    ]);

})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{id}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{id}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');

    Route::get('/groups/{id}/chats', [GroupController::class, 'chat'])->name('chats.index');
    Route::post('/groups/{id}/chats', [GroupController::class, 'postChat'])->name('chats.post');
    Route::get('/groups/{id}/chats/load', [GroupController::class, 'load'])->name('chats.load');
    Route::get('/groups/{id}/chats/download', [GroupController::class, 'download'])->name('chats.download');
    Route::get('/api/groups/{id}/chats', [GroupController::class, 'chatApi'])->name('chats.api');
    Route::get('/groups/{id}/members', [GroupController::class, 'members'])->name('groups.members');

    // join
    Route::post('/groups/{id}/join', [GroupController::class, 'join'])->name('groups.join');
    Route::post('/groups/{id}/leave', [GroupController::class, 'leave'])->name('groups.leave');
    Route::post('/groups/{id}/members/{memberId}/confirm', [GroupController::class, 'confirm'])->name('groups.members.confirm');
    Route::post('/groups/{id}/members/{memberId}/delete', [GroupController::class, 'delete'])->name('groups.members.delete');

    Route::post('/groups/{id}/reject', [GroupController::class, 'reject'])->name('groups.reject');
    Route::post('/groups/{id}/cancel', [GroupController::class, 'cancel'])->name('groups.cancel');
});

Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{id}/confirm', [UserController::class, 'confirm'])->name('users.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/grups', [GrupController::class, 'index'])->name('grups.index');
    Route::get('/grups/create', [GrupController::class, 'create'])->name('grups.create');
    Route::get('/grups/{id}/anggota', [GrupController::class, 'anggotaindex'])->name('grups.anggota.index');
    Route::delete('/grups/{id}/anggota/{id_anggota}', [GrupController::class, 'anggotadestroy'])->name('grups.anggota.destroy');
    Route::post('/grups/{id}/anggota/{id_anggota}/accept', [GrupController::class, 'anggotaaccept'])->name('grups.anggota.accept');
    Route::post('/grups', [GrupController::class, 'store'])->name('grups.store');
    Route::get('/grups/{id}/edit', [GrupController::class, 'edit'])->name('grups.edit');
    Route::put('/grups/{id}', [GrupController::class, 'update'])->name('grups.update');
    Route::delete('/grups/{id}', [GrupController::class, 'destroy'])->name('grups.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/anggota_grups', [AnggotaGrupController::class, 'index'])->name('anggota_grups.index');
    Route::get('/anggota_grups/create', [AnggotaGrupController::class, 'create'])->name('anggota_grups.create');
    Route::post('/anggota_grups', [AnggotaGrupController::class, 'store'])->name('anggota_grups.store');
    Route::get('/anggota_grups/{id}/edit', [AnggotaGrupController::class, 'edit'])->name('anggota_grups.edit');
    Route::put('/anggota_grups/{id}', [AnggotaGrupController::class, 'update'])->name('anggota_grups.update');
    Route::delete('/anggota_grups/{id}', [AnggotaGrupController::class, 'destroy'])->name('anggota_grups.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/like/{postId}', [PostLikeController::class, 'like'])->name('post.like');
});

Route::middleware('auth')->group(function () {
    Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
});

Route::middleware('auth')->group(function () {
    Route::post('/komentar', [KomentarController::class, 'store'])->name('comments.store');
    Route::get('/komentar/{id}/edit', [KomentarController::class, 'edit'])->name('komentar.edit');
    Route::put('/komentar/{id}', [KomentarController::class, 'update'])->name('komentar.update');
    Route::delete('/komentar/{id}', [KomentarController::class, 'destroy'])->name('komentar.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get("/private-chat/{postId}", [OrderController::class, 'privateChat'])->name('private-chat');
});

require __DIR__ . '/auth.php';
