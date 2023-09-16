<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Process;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
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
        // Define the command to run your crawler binary with arguments
        $crawlerCommand = '/bin/crawler https://www.cp24.com foo';

        // Execute the command using Process facade
        $process = Process::fromShellCommandline($crawlerCommand);
        $process->run();

        // Check if the process was successful
        if ($process->isSuccessful()) {
            // Handle success
            $output = $process->getOutput();
            // You can log or process the output here
        } else {
            // Handle failure
            $errorOutput = $process->getErrorOutput();
            // Log or handle the error
        }
    }

}
