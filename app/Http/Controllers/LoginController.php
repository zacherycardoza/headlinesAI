<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    function showLoginForm()
    {
        return view('auth.login');
    }

    function login()
    {
        return null;
    }
}
