<?php

namespace Tests\Feature;

use App\Jobs\FetchArticlesJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class FetchArticlesCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_dispatches_jobs_for_each_source()
    {
        Queue::fake();

        $this->artisan('app:fetch-articles-command')->assertExitCode(0);
        Queue::assertPushed(FetchArticlesJob::class, 3); // because we have 3 sources
    }
}
