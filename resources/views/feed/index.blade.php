@extends('layouts.app')

@section('title', 'Your Feed')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-gray-100">Your Feed</h1>

    {{-- Top Pagination --}}
    @if ($articles->hasPages())
    <div class="mt-8 pb-4 flex justify-end">
        <nav class="inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            @if ($articles->onFirstPage())
                <span class="px-3 py-1 rounded-l-md border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-400 cursor-not-allowed">&laquo;</span>
            @else
                <a href="{{ $articles->previousPageUrl() }}" class="px-3 py-1 rounded-l-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">&laquo;</a>
            @endif

            {{-- Small screens: current page only --}}
            <span class="px-3 py-1 border-t border-b border-gray-300 dark:border-gray-700 bg-indigo-600 text-white sm:hidden">
                {{ $articles->currentPage() }}
            </span>

            {{-- Large screens: full range --}}
            @foreach ($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                @if ($page == $articles->currentPage())
                    <span class="hidden sm:inline px-3 py-1 border-t border-b border-gray-300 dark:border-gray-700 bg-indigo-600 text-white">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="hidden sm:inline px-3 py-1 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">{{ $page }}</a>
                @endif
            @endforeach

            @if ($articles->hasMorePages())
                <a href="{{ $articles->nextPageUrl() }}" class="px-3 py-1 rounded-r-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">&raquo;</a>
            @else
                <span class="px-3 py-1 rounded-r-md border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-400 cursor-not-allowed">&raquo;</span>
            @endif
        </nav>
    </div>
    @endif

    {{-- Articles Grid --}}
    @if($articles->count())
        <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
            @foreach($articles as $index => $article)
                {{-- Article Card --}}
                <div class="bg-white dark:bg-gray-800 shadow rounded p-6 hover:shadow-lg transition">
                    @if(!empty($article->image_url))
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-48 object-cover rounded mb-4">
                    @endif

                    <h2 class="text-xl font-semibold mb-1 text-gray-900 dark:text-gray-100">{{ $article->title }}</h2>

                    @if($article->topic)
                        <span class="text-sm text-gray-400 dark:text-gray-500 mb-2 inline-block">{{ $article->topic->name }}</span>
                    @endif

                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        {{ $article->summary ?? Str::limit($article->content, 150) }}
                    </p>

                    <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                        <span>{{ $article->source }}</span>
                        <span>{{ $article->published_at->format('M d, Y') }}</span>
                    </div>

                    <div class="mt-4">
                        <a href="{{ $article->url }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">Read full article</a>
                    </div>
                </div>

                {{-- Insert Ad every 3 articles --}}
                @if(($index + 1) % 4 === 0)
                    <div class="col-span-full my-6 p-4 bg-gray-100 dark:bg-gray-700 text-center rounded">
                        <span class="text-gray-500 dark:text-gray-300">Advertisement</span>
                        {{-- Replace below with actual ad script --}}
                        <div class="mt-2">
                            <img src="https://via.placeholder.com/728x90?text=Your+Ad+Here" alt="Ad" class="mx-auto">
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Bottom Pagination --}}
        @if ($articles->hasPages())
        <div class="mt-8 pb-4 flex justify-end">
            <nav class="inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                @if ($articles->onFirstPage())
                    <span class="px-3 py-1 rounded-l-md border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-400 cursor-not-allowed">&laquo;</span>
                @else
                    <a href="{{ $articles->previousPageUrl() }}" class="px-3 py-1 rounded-l-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">&laquo;</a>
                @endif

                <span class="px-3 py-1 border-t border-b border-gray-300 dark:border-gray-700 bg-indigo-600 text-white sm:hidden">
                    {{ $articles->currentPage() }}
                </span>

                @foreach ($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                    @if ($page == $articles->currentPage())
                        <span class="hidden sm:inline px-3 py-1 border-t border-b border-gray-300 dark:border-gray-700 bg-indigo-600 text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="hidden sm:inline px-3 py-1 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($articles->hasMorePages())
                    <a href="{{ $articles->nextPageUrl() }}" class="px-3 py-1 rounded-r-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">&raquo;</a>
                @else
                    <span class="px-3 py-1 rounded-r-md border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-400 cursor-not-allowed">&raquo;</span>
                @endif
            </nav>
        </div>
        @endif

    @else
        <p class="text-gray-600 dark:text-gray-400">
            No articles available for your topics yet. Check back later!
        </p>
    @endif
</div>
@endsection
