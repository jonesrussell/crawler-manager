<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request...
        $validated = $request->validate([
            'url' => 'required|string|max:255',
            'crawlsite_id' => 'required',
        ]);

        $article = Article::create($validated);

        return response()->json($article, 201);
    }
}
