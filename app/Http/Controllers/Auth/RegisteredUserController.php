<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     */
    public function store(Request $request): RedirectResponse
    {
        // Insert data into 'desa' table
        $desa = DB::table('desa')->insertGetId([
            'nama' => $request->nama,
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat,
        ]);

        // Insert data into 'users' table
        $user = DB::table('users')->insertGetId([
            'name' => $request->name,
            'role' => 'Admin',
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'is_confirmed' => true,
            'id_desa' => $desa,
        ]);

        $user = User::find($user);

        // Trigger the Registered event
        event(new Registered($user));

        // Log in the user
        Auth::loginUsingId($user);

        // Redirect to the dashboard
        return redirect()->route('dashboard');
    }
}
