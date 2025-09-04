<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    function showRegistrationForm()
    {
        return view('auth.register');
    }

    function register()
    {
        return null;
    }
}
