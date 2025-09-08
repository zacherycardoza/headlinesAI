@extends('layouts.app')

@section('title', 'Select Your Topics')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">Select Your Topics</h1>

    <form action="{{ route('topics.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            @foreach($topics as $topic)
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="topics[]" value="{{ $topic->id }}"
                        {{ in_array($topic->id, $userTopics) ? 'checked' : '' }}>
                    <span>{{ $topic->name }}</span>
                </label>
            @endforeach
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            Save Topics
        </button>
    </form>
</div>
@endsection
