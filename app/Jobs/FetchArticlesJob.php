<?php

namespace App\Jobs;

use App\Services\FetchArticlesService;
use App\Services\Strategies\SourceRequestStrategy;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchArticlesJob implements ShouldQueue
{
    use Queueable;
    protected SourceRequestStrategy $strategy;

    /**
     * Create a new job instance.
     */
    public function __construct(SourceRequestStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * Execute the job.
     */
    public function handle(FetchArticlesService $fetchArticlesService): void
    {
        $fetchArticlesService->setStrategy($this->strategy);
        $fetchArticlesService->fetchAndStoreArticles();
    }
}
