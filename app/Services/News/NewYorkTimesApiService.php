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

    public function fetchArticles(int $page = 1, int $pageSize = 10, array $params = []): array
    {
        $apiKey = config('services.newyorktimes.key');
        $baseUrl = config('services.newyorktimes.base_url');

        $allowed = ['q', 'category', 'country', 'sources'];

        $filteredParams = array_intersect_key($params, array_flip($allowed));

        $query = array_merge($filteredParams, [
            'api-key' => $apiKey,
            'sort' => 'newest',
            'page' => $page,
        ]);

        $response = Http::get($baseUrl . 'world.json', $query);

        return collect($response->json('results', []))
            ->map(fn ($item) => $this->transformer->transform($item))
            ->all();
    }
}
