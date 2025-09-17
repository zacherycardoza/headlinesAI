<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HeadlinesAI')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <nav class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-gray-800 dark:text-gray-100">HeadlinesAI</a>
            <div class="space-x-4 flex items-center">
                @guest
                    <a href="#features" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Features</a>
                    <a href="#pricing" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Pricing</a>
                    <a href="#contact" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Contact</a>
                    <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-white dark:bg-gray-700 text-indigo-600 border border-indigo-600 px-4 py-2 rounded hover:bg-indigo-50 dark:hover:bg-gray-600 transition">Sign Up</a>
                @else
                    <a href="{{ route('feed') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">My Feed</a>
                    <a href="{{ route('topics') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Topics</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                @endguest

                <!-- Dark mode toggle button -->
                <button id="theme-toggle" class="ml-4 px-3 py-2 rounded bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200">
                    🌙
                </button>
            </div>
        </div>
    </nav>

    <main class="text-gray-900 dark:text-gray-100">
        @yield('content')
    </main>

    <footer class="bg-white dark:bg-gray-800 shadow mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-gray-600 dark:text-gray-400">
            &copy; {{ date('Y') }} HeadlinesAI. All rights reserved.
        </div>
    </footer>

    <script>
        const toggle = document.getElementById('theme-toggle');
        const html = document.documentElement;

        function applyTheme(theme) {
            if (theme === 'dark') {
                html.classList.add('dark');
                toggle.textContent = '☀️';
            } else {
                html.classList.remove('dark');
                toggle.textContent = '🌙';
            }
        }

        // Decide initial theme
        let savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            applyTheme(savedTheme);
        } else {
            // No preference saved → use system setting
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                applyTheme('dark');
            } else {
                applyTheme('light');
            }
        }

        // Toggle on click
        toggle.addEventListener('click', () => {
            if (html.classList.contains('dark')) {
                localStorage.setItem('theme', 'light');
                applyTheme('light');
            } else {
                localStorage.setItem('theme', 'dark');
                applyTheme('dark');
            }
        });

        // Optional: react to system changes live
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                applyTheme(e.matches ? 'dark' : 'light');
            }
        });
    </script>
</body>
</html>
