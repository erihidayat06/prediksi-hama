<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Default redirect (kalau bukan admin)
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirect user after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return '/admin';
        }

        return '/';
    }
}
