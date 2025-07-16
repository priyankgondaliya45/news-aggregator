<?php

namespace Database\Seeders;

use App\Models\NewsProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsProvider::insert([
            ['name' => 'The Guardian', 'slug' => 'guardian'],
            ['name' => 'NewsAPI', 'slug' => 'newsapi'],
            ['name' => 'New York Times', 'slug' => 'nyt'],
        ]);
    }
}
