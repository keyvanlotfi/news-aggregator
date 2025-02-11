<?php

namespace App\Console\Commands;

use App\Jobs\FetchArticlesJob;
use App\Repositories\ArticleRepositoryInterface;
use App\Services\FetchArticlesService;
use App\Services\Strategies\NewsApiStrategy;
use App\Services\Strategies\NewYorkTimesStrategy;
use App\Services\Strategies\TheGuardianStrategy;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-articles-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles from sources and store them in the database';


    public function __construct(private FetchArticlesService $fetchArticlesService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sources = [
            new NewsApiStrategy(),
            new NewYorkTimesStrategy(),
            new TheGuardianStrategy(),
        ];

        foreach ($sources as $source) {
            FetchArticlesJob::dispatch($source);
        }

        $this->info('✅ Jobs dispatched for fetching articles!');
    }
}
