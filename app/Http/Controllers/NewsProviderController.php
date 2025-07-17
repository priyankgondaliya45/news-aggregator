<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderFilterRequest;
use App\Http\Resources\NewsProviderResource;
use App\Models\NewsProvider;
use Illuminate\Http\Request;

class NewsProviderController extends Controller
{
    public function index(ProviderFilterRequest $request)
    {
        $query = NewsProvider::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $perPage = $request->input('per_page', 20);

        $providers = $query->orderBy('name')->paginate($perPage);

        return NewsProviderResource::collection($providers);
    }
}
