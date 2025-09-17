@extends('layouts.app')

@section('title', 'Select Your Topics')

@section('content')
@php
    // Mapping topics to Unsplash stock images
    $topicImages = [
        'Technology' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=800&q=80',
        'Sports' => 'https://images.unsplash.com/photo-1549896869-ca27eeffe4fb?auto=format&fit=crop&w=800&q=80',
        'Politics' => 'https://images.unsplash.com/photo-1555848962-6e79363ec58f?auto=format&fit=crop&w=800&q=80',
        'Health' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=800&q=80',
        'Business' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80',
        'Entertainment' => 'https://images.unsplash.com/photo-1603190287605-e6ade32fa852?auto=format&fit=crop&w=800&q=80',
        'Environment' => 'https://images.unsplash.com/photo-1416169607655-0c2b3ce2e1cc?auto=format&fit=crop&w=800&q=80',
        'AI & ML' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&w=800&q=80',
        'Science' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=800&q=80',
        'Gaming'  => 'https://images.unsplash.com/photo-1612287230202-1ff1d85d1bdf?auto=format&fit=crop&w=800&q=80',
    ];
@endphp

<div class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8 text-center">Select Your Topics</h1>

    <form action="{{ route('topics.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($topics as $topic)
                <label class="relative cursor-pointer group">
                    <input type="checkbox" name="topics[]" value="{{ $topic->id }}"
                        class="absolute inset-0 w-full h-full opacity-0 peer"
                        {{ in_array($topic->id, $userTopics) ? 'checked' : '' }}>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 peer-checked:ring-4 peer-checked:ring-indigo-500 transition transform hover:scale-105">
                        <div class="h-40">
                            <img src="{{ $topicImages[$topic->name] ?? 'https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d?auto=format&fit=crop&w=800&q=80' }}"
                                 alt="{{ $topic->name }}"
                                 class="h-full w-full object-cover">
                        </div>
                        <div class="p-4 text-center">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $topic->name }}</h3>
                        </div>
                    </div>

                    <div class="absolute top-3 right-3 hidden peer-checked:block">
                        <span class="bg-indigo-600 text-white text-xs px-2 py-1 rounded">Selected</span>
                    </div>
                </label>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-indigo-700 transition">
                Save Topics
            </button>
        </div>
    </form>
</div>
@endsection
