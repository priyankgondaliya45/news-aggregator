<?php

namespace App\Services\News;

use App\Models\Article;
use App\Models\Author;
use App\Models\NewsCategory;
use App\Models\NewsProvider;
use App\Models\NewsSource;
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
            if (!$integration instanceof NewsIntegrationInterface) {
                continue;
            }

            $this->handleIntegration($integration, $logger);
        }
    }

    protected function handleIntegration(NewsIntegrationInterface $integration, ?callable $logger = null): void
    {
        $provider = $this->getProviderBySlug($integration->getProviderSlug());

        if (!$provider) {
            $this->log($logger, "Skipping unknown provider: " . ucfirst($integration->getProviderSlug()));
            return;
        }

        $this->log($logger, "Fetching articles from {$provider->name}...");

        $page = 1;
        $pageSize = 10;
        $totalFetched = 0;

        do {
            $articles = $integration->fetchArticles($page, $pageSize);
            $countThisPage = count($articles);

            if ($countThisPage === 0)
                break;

            $this->log($logger, "Page {$page} fetched: {$countThisPage} articles.");

            foreach ($articles as $articleDTO) {
                $this->storeArticle($articleDTO, $provider);
                $totalFetched++;
            }

            $page++;
        } while ($countThisPage === $pageSize);

        $this->log($logger, "Done fetching from {$provider->name}. Total: {$totalFetched} articles fetched.");
    }

    protected function getProviderBySlug(?string $slug): ?NewsProvider
    {
        $slug = $slug ?? 'unknown';
        return NewsProvider::where('slug', $slug)->first();
    }


    protected function storeArticle($articleDTO, $provider): void
    {
        $categoryId = $this->getCategoryId($articleDTO->category ?? 'uncategorized', $provider->id);
        $authorId = $this->getAuthorId($articleDTO->author ?? null, $provider->id);
        $sourceId = $this->getSourceId($articleDTO->sourceName ?? 'Unknown', $provider->id);

        Article::updateOrCreate(
            ['url' => $articleDTO->url],
            array_merge($articleDTO->toArray(), [
                'author_id' => $authorId,
                'source_id' => $sourceId,
                'provider_id' => $provider->id,
                'category_id' => $categoryId,
            ])
        );
    }
    protected function getCategoryId(string $categoryName, int $providerId): int
    {
        $slug = Str::slug($categoryName);

        return NewsCategory::firstOrCreate(
            ['slug' => $slug],
            ['name' => $categoryName, 'provider_id' => $providerId]
        )->id;
    }

    protected function getAuthorId(?string $authorName, int $providerId): ?int
    {
        if (!$authorName)
            return null;

        return Author::firstOrCreate(
            ['name' => $authorName, 'provider_id' => $providerId]
        )->id;
    }

    protected function getSourceId(string $sourceName, int $providerId): int
    {
        return NewsSource::firstOrCreate(
            ['name' => $sourceName, 'provider_id' => $providerId]
        )->id;
    }

    protected function log(?callable $logger, string $message): void
    {
        if (is_callable($logger)) {
            $logger($message);
        }
    }

}
