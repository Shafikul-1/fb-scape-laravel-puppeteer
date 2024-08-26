<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ScapeController extends Controller
{
    public function index()
    {
        $nodeExec = 'node';
        $scriptPath = base_path('resources/js/index.js');

        // Usernames array
        $usernames = [
            'TroyMichaelPhotgraphy',
            'SpiritOfTheTetonsPhotography',
            'profile.php?id=61552158826567'
        ];

        // Encode usernames to pass them to the Node.js script
        $encodedUsernames = json_encode($usernames, JSON_UNESCAPED_SLASHES);

        // Escape the JSON string properly
        $escapedUsernames = addslashes($encodedUsernames);

        // Construct the shell command
        $command = "$nodeExec $scriptPath \"$escapedUsernames\"";

        Log::info('Command: ' . $command);

        try {
            $output = shell_exec($command);
            Log::info('Node.js script executed successfully.');
            $datas = json_decode($output, true);
            return response()->json($datas);
        } catch (\Exception $e) {
            Log::error('Error executing Node.js script: ' . $e->getMessage());
            return response()->json(['message' => 'Error executing script'], 500);
        }
    }
}
