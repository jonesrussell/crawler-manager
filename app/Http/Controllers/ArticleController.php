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
            'urls.*' => 'required|string|max:255',
            'crawlsite_id' => 'required',
        ]);

        foreach ($validated['urls'] as $url) {
            Article::firstOrCreate(
                [
                    'url' => $url,
                    'crawlsite_id' => $validated['crawlsite_id']
                ]
            );
        }

        return response()->json([
            'message' => 'Articles Created Successfully',
        ], 201);
    }
}
