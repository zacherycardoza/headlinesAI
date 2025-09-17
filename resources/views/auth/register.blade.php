@extends('layouts.app')

@section('title', 'Sign Up - HeadlinesAI')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center">Create a HeadlinesAI Account</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-600 dark:text-red-400">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-gray-700 dark:text-gray-300">Name</label>
                <input id="name" type="text" name="name" required
                       class="mt-1 p-3 rounded border border-gray-300 dark:border-gray-600 w-full
                              bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                              focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div>
                <label for="email" class="block text-gray-700 dark:text-gray-300">Email</label>
                <input id="email" type="email" name="email" required
                       class="mt-1 p-3 rounded border border-gray-300 dark:border-gray-600 w-full
                              bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                              focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div>
                <label for="password" class="block text-gray-700 dark:text-gray-300">Password</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 p-3 rounded border border-gray-300 dark:border-gray-600 w-full
                              bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                              focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <div>
                <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="mt-1 p-3 rounded border border-gray-300 dark:border-gray-600 w-full
                              bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                              focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>
            <button type="submit"
                    class="w-full bg-indigo-600 text-white px-4 py-3 rounded hover:bg-indigo-700 transition">
                Sign Up
            </button>
        </form>
        <p class="mt-4 text-center text-gray-600 dark:text-gray-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Login</a>
        </p>
    </div>
</div>
@endsection
