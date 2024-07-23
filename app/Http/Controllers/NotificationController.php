<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index() {
        $id = auth()->user()->id;
        $notifications = DB::table('notification')->where('to', $id)->latest()->get();
        return view('notifications.index', [
            'notifications' => $notifications,
        ]);
    }
}
