<?php

namespace App\Jobs;

use App\Models\AllLink;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DatasCollectJob implements ShouldQueue
{
    use Queueable;

    public $datas;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->datas = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $getData =  AllLink::where('check', '=', 'valid')->limit(10)->pluck('link')->toArray();
        Log::info('Data aLL fetched: ' . json_encode($this->datas));

        $nodeExec = 'node';
        $scriptPath = base_path('resources/js/index.js');

        // Encode usernames to pass them to the Node.js script
        $encodedUsernames = json_encode($this->datas, JSON_UNESCAPED_SLASHES);

        // Escape the JSON string properly
        $escapedUsernames = addslashes($encodedUsernames);

        // Construct the shell command
        $command = "$nodeExec $scriptPath \"$escapedUsernames\"";

        // Log::info('Command: ' . $command);

        try {
            $output = shell_exec($command);
            Log::info('Node.js script executed successfully.');
            // $datas = json_decode($output, true);
            // $collectData = response()->json($datas);
            // Log::info('Collect Data ' . $collectData);
        } catch (\Exception $e) {
            Log::error('Error executing Node.js script: ' . $e->getMessage());
        }
    }
}
