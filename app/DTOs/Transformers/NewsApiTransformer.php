<?php

namespace App\DTOs\Transformers;

use App\DTOs\ArticleResponseDTO;
use App\DTOs\Contracts\ArticleTransformerInterface;

class NewsApiTransformer implements ArticleTransformerInterface
{
    public function transform(array $item): ArticleResponseDTO
    {
        return new ArticleResponseDTO(
            title: $item['title'] ?? 'Untitled',
            description: $item['description'] ?? null,
            content: $item['content'] ?? null,
            author: $item['author'] ?? null,
            url: $item['url'],
            urlToImage: $item['urlToImage'] ?? null,
            category: $item['category'] ?? null,
            sourceName: $item['source']['name'] ?? 'NewsAPI',
            publishedAt: new \DateTime($item['publishedAt'] ?? 'now')
        );
    }
}



?>