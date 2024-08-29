<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
        $nodeExec = 'node';
        $scriptPath = base_path('resources/js/index.js');

        // // Usernames array
        // $usernames = [
        //     'https://www.facebook.com/TroyMichaelPhotgraphy',
        //     'https://www.facebook.com/SpiritOfTheTetonsPhotography',
        //     'https://www.facebook.com/profile.php?id=61552158826567',
        //     'https://www.facebook.com/Hochzeitum3/',
        //     'https://www.facebook.com/nicolepleaseweddings/',
        //     'https://www.facebook.com/otashuz.studio/',
        // ];

        // Encode usernames to pass them to the Node.js script
        $encodedUsernames = json_encode($this->datas, JSON_UNESCAPED_SLASHES);

        // Escape the JSON string properly
        $escapedUsernames = addslashes($encodedUsernames);

        // Construct the shell command
        $command = "$nodeExec $scriptPath \"$escapedUsernames\"";

        Log::info('Command: ' . $command);

        try {
            $output = shell_exec($command);
            Log::info('Node.js script executed successfully.');
            $datas = json_decode($output, true);
            $collectData = response()->json($datas);
            Log::info('Console Print' . $collectData);
        } catch (\Exception $e) {
            Log::error('Error executing Node.js script: ' . $e->getMessage());
        }
    }
}
