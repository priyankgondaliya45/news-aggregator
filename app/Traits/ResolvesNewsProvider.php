<?php

namespace App\Traits;

use App\Models\NewsProvider;

trait ResolvesNewsProvider
{
    protected string $providerSlug;
    
    public function setProviderSlug(string $slug): void
    {
        $this->providerSlug = $slug;
    }
    
    public function getProviderSlug(): string
    {
        return $this->providerSlug;
    }

    public function getProviderId(): ?int
    {
        return NewsProvider::where('slug', $this->providerSlug)->value('id');
    }
}
