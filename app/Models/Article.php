<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'description',
        'content',
        'author_id',
        'url',
        'url_to_image',
        'category_id',
        'source_id',
        'published_at',
        'provider_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function source()
    {
        return $this->belongsTo(NewsSource::class);
    }

    public function provider()
    {
        return $this->belongsTo(NewsProvider::class);
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class);
    }
}
