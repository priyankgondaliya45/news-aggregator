<?php

namespace App\Services\News;

use App\DTOs\Transformers\GuardianTransformer;
use App\Services\News\Contracts\NewsIntegrationInterface;
use App\Traits\ResolvesNewsProvider;
use Illuminate\Support\Facades\Http;

class GuardianApiService implements NewsIntegrationInterface
{
    use ResolvesNewsProvider;

    public function __construct(
        protected GuardianTransformer $transformer
    ) {
        $this->setProviderSlug('guardian');
    }

    public function fetchArticles(int $page = 1, int $pageSize = 10, array $params = []): array
    {

        $apiKey = config('services.guardian.key');
        $baseUrl = config('services.guardian.base_url');

        $allowed = ['q', 'tag', 'from-date', 'to-date', 'section'];
        $filteredParams = array_intersect_key($params, array_flip($allowed));

        $query = array_merge($filteredParams, [
            'page' => $page,
            'page-size' => $pageSize,
            'api-key' => $apiKey,
        ]);

        $response = Http::get($baseUrl . 'search', $query);

        return collect($response->json('response.results', []))
            ->map(fn($item) => $this->transformer->transform($item))
            ->all();
    }
}
