<?php

namespace App\Jobs;

use App\Events\CrawlerJobOutputEvent;
use App\Jobs\ProcessUrlStream;
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

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    public $failOnTimeout = true;

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

        $crawlerCommand = "{$crawlerBinaryPath} crawl --url={$url} --search=\"{$searchTerms}\" --crawlsite={$crawlsiteId}";

        Log::info("Running Crawler command: $crawlerCommand");

        $result = Process::timeout(300)->run($crawlerCommand);

        $output = $result->output(); // Assign the output here

        event(new CrawlerJobOutputEvent($output)); // Pass $output to the event

        if ($result->successful()) {
            Log::info("Crawler job output: $output");

            CrawlerJobRun::create([
                'crawlsite_id' => $crawlsiteId,
                'output' => $output,
            ]);

            // Dispatch the ProcessUrlStream job as the next job in the chain
            ProcessUrlStream::dispatch($crawlsiteId, 'streetcode-consumers')->onQueue('url_stream_queue');
        } else {
            $errorOutput = $result->errorOutput();
            Log::error("Crawler job failed with error: $errorOutput");

            CrawlerJobRun::create([
                'crawlsite_id' => $crawlsiteId,
                'failed' => true,
                'output' => $output,
            ]);
        }

        Log::info("CrawlerJob completed.");
    }
}
