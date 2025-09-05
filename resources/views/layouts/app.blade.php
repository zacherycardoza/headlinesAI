<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HeadlinesAI')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-gray-800">HeadlinesAI</a>
            <div class="space-x-4">

                @guest
                    <a href="#features" class="text-gray-600 hover:text-gray-900">Features</a>
                    <a href="#pricing" class="text-gray-600 hover:text-gray-900">Pricing</a>
                    <a href="#contact" class="text-gray-600 hover:text-gray-900">Contact</a>
                    <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-indigo-600 border border-indigo-600 px-4 py-2 rounded hover:bg-indigo-50 transition">Sign Up</a>
                @else
                    <a href="{{ route('feed') }}" class="text-gray-600 hover:text-gray-900">My Feed</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white shadow mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-gray-600">
            &copy; {{ date('Y') }} HeadlinesAI. All rights reserved.
        </div>
    </footer>
</body>
</html>
