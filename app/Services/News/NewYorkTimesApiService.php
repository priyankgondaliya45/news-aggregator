<?php

namespace App\Services\News;

use App\DTOs\Transformers\NewYorkTimesTransformer;
use App\Services\News\Contracts\NewsIntegrationInterface;
use App\Traits\ResolvesNewsProvider;
use Illuminate\Support\Facades\Http;

class NewYorkTimesApiService implements NewsIntegrationInterface
{
    use ResolvesNewsProvider;
    
    public function __construct(
        protected NewYorkTimesTransformer $transformer
    ) {
        $this->setProviderSlug('nyt');
    }

    public function fetchArticles(int $page = 1, int $pageSize = 10): array
    {
        $apiKey = config('services.newyorktimes.key');
        $baseUrl = config('services.newyorktimes.base_url');

        $response = Http::get($baseUrl . 'home.json', [
            'api-key' => $apiKey,
            'sort' => 'newest',
            'page' => $page,
        ]);

        return collect($response->json('results', []))
            ->map(fn ($item) => $this->transformer->transform($item))
            ->all();
    }
}
