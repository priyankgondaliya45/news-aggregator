<?php

namespace App\DTOs\Transformers;

use App\DTOs\ArticleResponseDTO;
use App\DTOs\Contracts\ArticleTransformerInterface;

class NewYorkTimesTransformer implements ArticleTransformerInterface
{
    public function transform(array $item): ArticleResponseDTO
    {
        return new ArticleResponseDTO(
            title: $item['title'] ?? 'Untitled',
            description: $item['abstract'] ?? null,
            content: null,
            author: $item['byline'] ?? null,
            url: $item['url'],
            urlToImage: $item['multimedia'][0]['url'] ?? null,
            category: $item['section'] ?? null,
            sourceName: $item['source'] ?? 'New York Times',
            publishedAt: new \DateTime($item['published_date'] ?? 'now')
        );
    }
}
