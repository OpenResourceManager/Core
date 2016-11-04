<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return $this
     */
    public function index()
    {
        $user = Auth::user();

        $roles = $user->roles()->with('perms')->get();

        return view('home')->with(['roles' => $roles]);
    }
}