<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ProcessUrlStream implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $crawlsiteId;
    protected $group;

    /**
     * Create a new job instance.
     *
     * @param string $crawlsiteId
     * @param string $group
     */
    public function __construct(string $crawlsiteId, string $group)
    {
        $this->crawlsiteId = $crawlsiteId;
        $this->group = $group;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $streamName = 'streetcode:' . $this->crawlsiteId;

        Log::debug('BEFORE XREADGROUP');

        $uniqueIdentifier = uniqid(); // Generate a unique consumer identifier

        // Define the consumer name and XREADGROUP command
        $consumerName = $this->group . '-' . $uniqueIdentifier;
        $xreadGroupCommand = [
            $streamName => '0',
            $consumerName => '>',
        ];

        Log::debug('Raw XREADGROUP Command: ' . json_encode($xreadGroupCommand));

        try {
            // Read and process entries from the Redis stream using XREADGROUP
            $entries = Redis::xReadGroup($this->group, $consumerName, $xreadGroupCommand, 1);
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error in Redis::xReadGroup: ' . $e->getMessage());
            return;
        }

        Log::debug('AFTER XREADGROUP');

        // Check if there are any entries to process
        if (empty($entries)) {
            // Log a message when there are no entries
            Log::info("No entries to process in stream: $streamName");
            return;
        }

        Log::info('Found ' . count($entries) . ' entries to process in stream: ' . $streamName);

        // Process each entry
        foreach ($entries as $stream => $streamEntries) {
            foreach ($streamEntries as $entry) {
                // Access individual fields of the entry
                $eventName = $entry['message']['eventName'] ?? null;
                $href = $entry['message']['href'];

                // Log the event name and entry data
                Log::info("Processing entry with Event Name: $eventName");
                Log::info("Entry href: " . json_encode($href));

                // Your custom processing logic here
                // For example, you can save the data to a database, perform actions, etc.

                // Acknowledge the entry after processing
                Redis::xAck($streamName, $this->group, [$entry['messageId']]);
            }
        }
    }
}
