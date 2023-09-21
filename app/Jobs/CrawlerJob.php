<?php

namespace App\Jobs;

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

    protected $url;
    protected $crawlsiteId;

    public function __construct($url, $crawlsiteId)
    {
        $this->url = $url;
        $this->crawlsiteId = $crawlsiteId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Log that the job has started
        Log::info("CrawlerJob started for crawling.");

        $url = $this->url;
        $crawlsiteId = $this->crawlsiteId;

        $crawlerBinaryPath = config('app.crawler_binary');

        if (!file_exists($crawlerBinaryPath)) {
            // Handle the case where the binary doesn't exist
            $this->fail("Crawler binary does not exist at {$crawlerBinaryPath}");
            Log::error("Crawler binary does not exist at {$crawlerBinaryPath}");
            return;
        }

        // Define the command to run your crawler binary with arguments
        $crawlerCommand = "{$crawlerBinaryPath} {$url} foo";

        // Log the full command before executing it
        Log::info("Running Crawler command: $crawlerCommand");

        // Execute the command using Laravel's Process facade
        $result = Process::forever()->run($crawlerCommand);

        // Log the standard output
        Log::info("Crawler job output: " . $result->output());

        // Log the error output
        Log::error("Crawler job error output: " . $result->errorOutput());

        // Check if the process was successful
        if ($result->successful()) {
            $output = $result->output();
            // Log the output
            Log::info("Crawler job output: $output");

            // Create a new CrawlerJobRun record associated with a Crawlsite
            CrawlerJobRun::create([
                'crawlsite_id' => $crawlsiteId, // Replace with the actual Crawlsite ID
                // Add other attributes you want to store for this run
            ]);
        } else {
            // Handle failure
            $errorOutput = $result->errorOutput();
            // Log or handle the error
            Log::error("Crawler job failed with error: $errorOutput");

            // Create a failed CrawlerJobRun record
            CrawlerJobRun::create([
                'crawlsite_id' => $crawlsiteId,
                'failed' => true, // You can add a 'failed' column to indicate failure
                // Add other attributes if needed
            ]);
        }

        // Log that the job has completed
        Log::info("CrawlerJob completed.");
    }
}
