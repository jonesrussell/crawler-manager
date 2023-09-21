<?php

namespace App\Jobs;

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
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Log that the job has started
        Log::info("CrawlerJob started for crawling.");

        $crawlerBinaryPath = config('app.crawler_binary');

        if (!file_exists($crawlerBinaryPath)) {
            // Handle the case where the binary doesn't exist
            $this->fail("Crawler binary does not exist at {$crawlerBinaryPath}");
            Log::error("Crawler binary does not exist at {$crawlerBinaryPath}");
            return;
        }

        // Define the command to run your crawler binary with arguments
        $crawlerCommand = "{$crawlerBinaryPath} https://www.cp24.com foo";

        // Execute the command using Laravel's Process facade
        $result = Process::run($crawlerCommand);

        // Check if the process was successful
        if ($result->successful()) {
            $output = $result->output();
            // Log the output
            Log::info("Crawler job output: $output");
        } else {
            // Handle failure
            $errorOutput = $result->errorOutput();
            // Log or handle the error
            Log::error("Crawler job failed with error: $errorOutput");
        }

        // Log that the job has completed
        Log::info("CrawlerJob completed.");
    }
}
