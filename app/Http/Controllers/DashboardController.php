<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()
                ->route('auth.login')
                ->withErrors('Silahkan login terlebih dahulu');
        }
        return view('admin.dashboard');
    }
}
