@extends('layouts.app')

@section('title', 'Your Feed')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Your Feed</h1>

    @if($articles->count())
        <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
            @foreach($articles as $article)
                <div class="bg-white shadow rounded p-6 hover:shadow-lg transition">

                    @if(!empty($article->image_url))
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-48 object-cover rounded mb-4">
                    @endif

                    <h2 class="text-xl font-semibold mb-1">{{ $article->title }}</h2>
                    @if($article->topic)
                        <span class="text-sm text-gray-400 mb-2 inline-block">{{ $article->topic->name }}</span>
                    @endif
                    <p class="text-gray-700 mb-4">{{ $article->summary ?? Str::limit($article->content, 150) }}</p>

                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span>{{ $article->source }}</span>
                        <span>{{ $article->published_at->format('M d, Y') }}</span>
                    </div>

                    <div class="mt-4">
                        <a href="{{ $article->url }}" target="_blank" class="text-indigo-600 hover:underline">
                            Read full article
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    @else
        <p class="text-gray-600">No articles available for your topics yet. Check back later!</p>
    @endif
</div>
@endsection
