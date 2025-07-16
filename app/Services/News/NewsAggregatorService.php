<?php

namespace App\Services\News;

use App\Models\Article;
use Illuminate\Support\Str;
use App\Services\News\Contracts\NewsIntegrationInterface;

class NewsAggregatorService
{
    protected iterable $integrations;

    public function __construct(iterable $integrations)
    {
        $this->integrations = $integrations;
    }

    public function fetchAndStoreAll(?callable $logger = null): void
    {
        foreach ($this->integrations as $integration) {
            if (!$integration instanceof NewsIntegrationInterface) continue;

            $providerSlug = $integration->getProviderSlug() ?? 'unknown';

            $provider = \App\Models\NewsProvider::where('slug', $providerSlug)->first();
            $providerId = $provider?->id;
            $providerName = $provider?->name ?? ucfirst($providerSlug);

            if (!$providerId) {
                if (is_callable($logger)) {
                    $logger("Skipping unknown provider: {$providerName}...");
                    continue;
                }
            }

            if (is_callable($logger)) {
                $logger("Fetching articles from {$providerName}...");
            }

            $page = 1;
            $pageSize = 10;
            $totalFetched = 0;

            do {
                $articles = $integration->fetchArticles($page, $pageSize);
                $countThisPage = count($articles);

                if ($countThisPage === 0) {
                    break;
                }

                if (is_callable($logger)) {
                    $logger("Page {$page} fetched: {$countThisPage} articles.");
                }

                foreach ($articles as $articleDTO) {
                    $totalFetched++;

                    $authorName = $articleDTO->author ?? null;
                    $sourceName = $articleDTO->sourceName ?? 'Unknown';
                    $categoryName = $articleDTO->category ?? 'uncategorized';
                    $categorySlug = \Illuminate\Support\Str::slug($categoryName);

                    $categoryId = \App\Models\NewsCategory::firstOrCreate(
                        ['slug' => $categorySlug],
                        ['name' => $categoryName, 'provider_id' => $providerId]
                    )->id;

                    $authorId = null;
                    if ($authorName) {
                        $authorId = \App\Models\Author::firstOrCreate(
                            ['name' => $authorName, 'provider_id' => $providerId]
                        )->id;
                    }

                    $sourceId = \App\Models\NewsSource::firstOrCreate(
                        ['name' => $sourceName, 'provider_id' => $providerId]
                    )->id;

                    Article::updateOrCreate(
                        ['url' => $articleDTO->url],
                        array_merge($articleDTO->toArray(), [
                            'author_id' => $authorId,
                            'source_id' => $sourceId,
                            'provider_id' => $providerId,
                            'category_id' => $categoryId,
                        ])
                    );
                }
                $page++;
            } while ($countThisPage === $pageSize);

            if (is_callable($logger)) {
                $logger("Done fetching from {$providerName}. Total: {$totalFetched} articles fetched.");
            }
        }
    }
}
