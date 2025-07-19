<?php

namespace App\Services\News;

use App\DTOs\Transformers\NewYorkTimesTransformer;
use App\Services\News\Contracts\NewsIntegrationInterface;
use App\Traits\ResolvesNewsProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $sections = config('services.newyorktimes.sections');
        $results = [];
        $allowed = ['q', 'category', 'country', 'sources'];

        $filteredParams = array_intersect_key($params, array_flip($allowed));

        $query = array_merge($filteredParams, [
            'api-key' => $apiKey,
            'sort' => 'newest',
            'page' => $page,
        ]);

        foreach ($sections as $section) {
            $url = "{$baseUrl}{$section}.json";
            $response = Http::get($url, $query);
            if ($response->successful()) {
                $articles = collect($response->json('results', []))
                ->take($pageSize)
                ->map(fn($item) => $this->transformer->transform($item))
                ->all();
                
                $results = array_merge($results, $articles);
                // dd($results);
            } else {
                Log::warning("Failed to fetch NYT section: {$section}");
            }
        }
        return $results;
    }
}
