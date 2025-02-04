<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\FetchNewsData;
use App\Services\ArticleService;
use Mockery;
use Illuminate\Support\Facades\Artisan;

class FetchNewsDataTest extends TestCase
{
    public function test_fetch_news_data_command_warns_no_news_data()
    {
        $articleServiceMock = Mockery::mock(ArticleService::class);

        $articleServiceMock->shouldReceive('SaveAllFetchedNewsApies')
            ->once()
            ->andReturn([]); // Simulate empty array response

        $this->app->instance(ArticleService::class, $articleServiceMock);

        $this->artisan('app:fetch-news-data')
            ->expectsOutput('There is not news data.')
            ->assertExitCode(0);
    }

    public function test_fetch_news_data_command_executes_successfully()
    {
        $articleServiceMock = Mockery::mock(ArticleService::class);
        
        $articleServiceMock->shouldReceive('SaveAllFetchedNewsApies')
            ->once()
            ->andReturn(['article1', 'article2']); // Simulate non-empty array response

        $this->app->instance(ArticleService::class, $articleServiceMock);

        $this->artisan('app:fetch-news-data')
            ->expectsOutput('News data fetched and stored successfully.')
            ->assertExitCode(0);
    }
}
