<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\UserArticleInteraction;

class FeedController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $articles = Article::whereIn('topic_id', $user->topics->pluck('id'))
            ->orderBy('published_at', 'desc')
            // ->with(['interactions' => fn($q) => $q->where('user_id', $user->id)])
            ->paginate(10);

        return view('feed.index', compact('articles'));
    }
}
