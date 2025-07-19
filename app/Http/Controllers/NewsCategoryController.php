<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryFilterRequest;
use App\Http\Resources\NewsCategoryResource;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    public function index(CategoryFilterRequest $request)
    {
        $limit = config('news-aggregator.pagination_limit');
        $query = NewsCategory::with('provider');

        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $perPage = $request->input('per_page', $limit);

        $categories = $query->orderBy('name')->paginate($perPage);

        return NewsCategoryResource::collection($categories);
    }
}
