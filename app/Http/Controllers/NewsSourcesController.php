<?php

namespace App\Http\Controllers;

use App\Http\Requests\SourceFilterRequest;
use App\Http\Resources\NewsSourceResource;
use App\Models\NewsSource;
use Illuminate\Http\Request;

class NewsSourcesController extends Controller
{
    public function index(SourceFilterRequest $request)
    {
        $limit = config('news-aggregator.pagination_limit');
        $query = NewsSource::with('provider');

        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $perPage = $request->input('per_page', $limit);

        $sources = $query->orderBy('name')->paginate($perPage);

        return NewsSourceResource::collection($sources);
    }
}
