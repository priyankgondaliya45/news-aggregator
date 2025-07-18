<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleFilterRequest;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(ArticleFilterRequest $request)
    {
        $query = Article::with(['author', 'source', 'provider', 'category']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        if ($request->filled('source_id')) {
            $query->where('source_id', $request->source_id);
        }

        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }

        if ($request->filled('published_from')) {
            $query->whereDate('published_at', '>=', $request->published_from);
        }

        if ($request->filled('published_to')) {
            $query->whereDate('published_at', '<=', $request->published_to);
        }

        $perPage = $request->input('per_page', 20);

        $articles = $query->latest('published_at')->paginate($perPage);

        return ArticleResource::collection($articles);
    }
}
