<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name', 'provider_id'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function provider()
    {
        return $this->belongsTo(NewsProvider::class);
    }
}
