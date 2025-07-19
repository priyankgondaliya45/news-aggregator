<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorFilterRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(AuthorFilterRequest $request)
    {
        $limit = config('news-aggregator.pagination_limit');
        $query = Author::with('provider');

        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $perPage = $request->input('per_page', $limit);

        $authors = $query->orderBy('name')->paginate($perPage);

        return AuthorResource::collection($authors);
    }
}
