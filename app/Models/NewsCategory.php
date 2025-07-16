<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $fillable = ['name', 'slug', 'provider_id'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function provider()
    {
        return $this->belongsTo(NewsProvider::class);
    }
}
