<?php

namespace App\Services\News;

use App\DTOs\Transformers\NewsApiTransformer;
use App\Services\News\Contracts\NewsIntegrationInterface;
use App\Traits\ResolvesNewsProvider;
use Illuminate\Support\Facades\Http;

class NewsApiService implements NewsIntegrationInterface
{
    use ResolvesNewsProvider;

    public function __construct(
        protected NewsApiTransformer $transformer
    ) {
        $this->setProviderSlug('newsapi');
    }

    public function fetchArticles(int $page = 1, int $pageSize = 10, array $params = []): array
    {
        $apiKey = config('services.newsapi.key');
        $baseUrl = config('services.newsapi.base_url');

        $allowed = ['q', 'category', 'country', 'sources'];

        $filteredParams = array_intersect_key($params, array_flip($allowed));

        $query = array_merge($filteredParams, [
            'apiKey' => $apiKey,
            'page' => $page,
            'pageSize' => $pageSize,
            'country' => $filteredParams['country'] ?? 'us',
        ]);

        $response = Http::get($baseUrl . 'top-headlines', $query);

        return collect($response->json('articles', []))
            ->map(fn($item) => $this->transformer->transform($item))
            ->all();
    }
}
