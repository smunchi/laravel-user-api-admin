<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::role('customer')->get();
        return view('backend.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('backend.users.show', compact('user'));
    }
}
