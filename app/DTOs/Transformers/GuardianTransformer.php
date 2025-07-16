<?php

namespace App\DTOs\Transformers;

use App\DTOs\ArticleResponseDTO;
use App\DTOs\Contracts\ArticleTransformerInterface;

class GuardianTransformer implements ArticleTransformerInterface
{
    public function transform(array $item): ArticleResponseDTO
    {
        return new ArticleResponseDTO(
            title: $item['webTitle'] ?? 'Untitled',
            description: null, 
            content: null,     
            author: null,      
            url: $item['webUrl'],
            urlToImage: null,  
            category: $this->extractSectionFromId($item['id'] ?? ''),
            sourceName: 'The Guardian',
            publishedAt: new \DateTime($item['webPublicationDate'] ?? 'now')
        );
    }

    private function extractSectionFromId(string $id): ?string
    {
        $parts = explode('/', $id);
        return $parts[0] ?? null;
    }

}



?>