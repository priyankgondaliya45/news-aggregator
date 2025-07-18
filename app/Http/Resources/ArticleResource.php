<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'url'           => $this->url,
            'image_url'     => $this->image_url,
            'published_at'  => $this->published_at,
            'author'        => optional($this->author)->name,
            'source'        => optional($this->source)->name,
            'category'      => optional($this->category)->name,
            'provider'      => optional($this->provider)->name,
            'created_at'    => $this->created_at,
        ];
    }
}
