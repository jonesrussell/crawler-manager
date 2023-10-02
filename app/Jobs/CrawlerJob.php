<?php

namespace App\Jobs;

use App\Events\CrawlerJobOutputEvent;
use App\Models\CrawlerJobRun;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CrawlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        Log::info("CrawlerJob started for crawling.");

        $url = $this->data['url'];
        $searchTerms = $this->data['searchTerms'];
        $crawlsiteId = $this->data['crawlsiteId'];

        $crawlerBinaryPath = config('app.crawler_binary');

        if (!file_exists($crawlerBinaryPath)) {
            $this->fail("Crawler binary does not exist at {$crawlerBinaryPath}");
            Log::error("Crawler binary does not exist at {$crawlerBinaryPath}");
            return;
        }

        $crawlerCommand = "{$crawlerBinaryPath} --url={$url} --search={$searchTerms}";

        Log::info("Running Crawler command: $crawlerCommand");

        $result = Process::forever()->run($crawlerCommand);

        $output = $result->output(); // Assign the output here

        // Log::info("Crawler job output: " . $output);
        // Log::error("Crawler job error output: " . $result->errorOutput());

        event(new CrawlerJobOutputEvent($output)); // Pass $output to the event

        if ($result->successful()) {
            Log::info("Crawler job output: $output");

            CrawlerJobRun::create([
                'crawlsite_id' => $crawlsiteId,
            ]);
        } else {
            $errorOutput = $result->errorOutput();
            Log::error("Crawler job failed with error: $errorOutput");

            CrawlerJobRun::create([
                'crawlsite_id' => $crawlsiteId,
                'failed' => true,
            ]);
        }

        Log::info("CrawlerJob completed.");
    }
}
