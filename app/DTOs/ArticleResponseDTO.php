<?php

// app/DTOs/ArticleResponseDTO.php

namespace App\DTOs;

class ArticleResponseDTO
{
    public string $title;
    public ?string $description;
    public ?string $content;
    public ?string $author;
    public string $url;
    public ?string $urlToImage;
    public ?string $category;
    public string $sourceName;
    public \DateTime $publishedAt;

    public function __construct(
        string $title,
        ?string $description,
        ?string $content,
        ?string $author,
        string $url,
        ?string $urlToImage,
        ?string $category,
        string $sourceName,
        \DateTime $publishedAt
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->author = $author;
        $this->url = $url;
        $this->urlToImage = $urlToImage;
        $this->category = $category;
        $this->sourceName = $sourceName;
        $this->publishedAt = $publishedAt;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'url' => $this->url,
            'url_to_image' => $this->urlToImage,
            'published_at' => $this->publishedAt->format('Y-m-d H:i:s'),
        ];
    }
}
