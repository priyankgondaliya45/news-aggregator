<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsProvider extends Model
{
    protected $fillable = ['name', 'slug'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
