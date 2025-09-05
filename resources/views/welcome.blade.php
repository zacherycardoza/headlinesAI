@extends('layouts.app')

@section('title', 'HeadlinesAI - AI Personalized News')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-20">
    <div class="max-w-7xl mx-auto text-center px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Your Personalized AI News Feed</h1>
        <p class="text-lg md:text-2xl mb-8">Get the headlines that matter to you, curated by AI.</p>
        <a href="#features" class="bg-white text-indigo-600 font-semibold px-6 py-3 rounded-lg shadow hover:bg-gray-100 transition">Get Started</a>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-lg shadow text-center hover:shadow-lg transition">
            <h3 class="text-xl font-bold mb-2 text-indigo-600">AI Curated</h3>
            <p>Our AI learns your preferences and delivers only the news that matters.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center hover:shadow-lg transition">
            <h3 class="text-xl font-bold mb-2 text-indigo-600">Fast & Responsive</h3>
            <p>Accessible anywhere, optimized for desktop and mobile devices.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center hover:shadow-lg transition">
            <h3 class="text-xl font-bold mb-2 text-indigo-600">Secure</h3>
            <p>Your data stays private and secure with industry-standard encryption.</p>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section id="pricing" class="bg-gray-100 py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-6 text-indigo-700">Pricing Plans</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-bold mb-2 text-indigo-600">Free</h3>
                <p class="mb-4">Basic AI news feed.</p>
                <p class="text-2xl font-bold mb-4">$0</p>
                <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Sign Up</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-bold mb-2 text-indigo-600">Pro</h3>
                <p class="mb-4">Full personalized experience.</p>
                <p class="text-2xl font-bold mb-4">$9/mo</p>
                <a href="#" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Coming Soon</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                <h3 class="text-xl font-bold mb-2 text-indigo-600">Enterprise</h3>
                <p class="mb-4">For large organizations and teams.</p>
                <p class="text-2xl font-bold mb-4">Contact us</p>
                <a href="#" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Coming Soon</a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-20">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-6 text-indigo-700">Contact Us</h2>
        <form class="grid gap-4">
            <input type="text" placeholder="Your Name" class="p-3 rounded border border-gray-300 w-full focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            <input type="email" placeholder="Your Email" class="p-3 rounded border border-gray-300 w-full focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            <textarea placeholder="Message" class="p-3 rounded border border-gray-300 w-full focus:ring-2 focus:ring-indigo-400 focus:outline-none"></textarea>
            <button class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-700 transition">Send Message</button>
        </form>
    </div>
</section>
@endsection
