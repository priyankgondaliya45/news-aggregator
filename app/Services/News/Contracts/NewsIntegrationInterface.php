<?php

namespace App\Services\News\Contracts;

interface NewsIntegrationInterface
{
    public function fetchArticles(): array;
    public function getProviderSlug(): string;
}

?>