<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AllLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ScapeController extends Controller
{
    public function index()
    {
        set_time_limit(120);

        $getData =  AllLink::where('check', '=', 'valid')->limit(3)->pluck('link')->toArray();

        $nodeExec = 'node';
        $scriptPath = base_path('resources/js/index.js');

        // Encode usernames to pass them to the Node.js script
        $encodedUsernames = json_encode($getData, JSON_UNESCAPED_SLASHES);

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
            return $collectData;
            // return view('allData', compact('datas'));
        } catch (\Exception $e) {
            Log::error('Error executing Node.js script: ' . $e->getMessage());
            return response()->json(['message' => 'Error executing script'], 500);
        }
    }

    public function  sentData()
    {
        return view('fbData.inputLink');
    }
}
