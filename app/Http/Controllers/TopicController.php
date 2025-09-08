<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends Controller
{
    public function edit()
    {
        $topics = Topic::all();
        $userTopics = auth()->user()->topics->pluck('id')->toArray();

        return view('topics.edit', compact('topics', 'userTopics'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'topics' => 'array',
            'topics.*' => 'exists:topics,id',
        ]);

        auth()->user()->topics()->sync($request->topics);

        return redirect()->route('feed')->with('success', 'Topics updated!');
    }
}
