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

        $this->applyFilters($query, $request);

        $articles = $query
            ->latest('published_at')
            ->paginate($request->input('per_page', 20));

        return ArticleResource::collection($articles);
    }

    protected function applyFilters($query, $request)
    {
        $filters = [
            'category_id',
            'author_id',
            'source_id',
            'provider_id',
        ];

        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->$filter);
            }
        }

        if ($request->filled('published_from')) {
            $query->whereDate('published_at', '>=', $request->published_from);
        }

        if ($request->filled('published_to')) {
            $query->whereDate('published_at', '<=', $request->published_to);
        }
    }
}
