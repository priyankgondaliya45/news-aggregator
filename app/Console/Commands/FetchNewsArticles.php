<?php

namespace App\Console\Commands;

use App\Services\News\NewsAggregatorService;
use Illuminate\Console\Command;

class FetchNewsArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest news articles from all integrated sources';

    protected NewsAggregatorService $aggregator;

    public function __construct(NewsAggregatorService $aggregator)
    {
        parent::__construct();
        $this->aggregator = $aggregator;
    }

    public function handle()
    {
        $this->info("Fetching articles from all integrations...");

        try {
            $this->aggregator->fetchAndStoreAll(function ($message) {
                $this->line($message);
            });
            $this->info("All articles fetched successfully.");
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
