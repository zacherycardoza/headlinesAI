@extends('layouts.app')

@section('title', 'Login - HeadlinesAI')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Login to HeadlinesAI</h2>
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-gray-700">Email</label>
                <input id="email" type="email" name="email" required autofocus class="mt-1 p-3 rounded border border-gray-300 w-full focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div>
                <label for="password" class="block text-gray-700">Password</label>
                <input id="password" type="password" name="password" required class="mt-1 p-3 rounded border border-gray-300 w-full focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <input type="checkbox" name="remember" id="remember" class="mr-1">
                    <label for="remember" class="text-gray-600">Remember Me</label>
                </div>
                <a  class="text-indigo-600 hover:underline text-sm">Forgot Password?</a>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-3 rounded hover:bg-indigo-700 transition">Login</button>
        </form>
    </div>
</div>
@endsection
