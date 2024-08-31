<?php

namespace App\Http\Controllers;

use App\Exports\ExportCollectData;
use App\Jobs\DatasCollectJob;
use App\Models\AllLink;
use App\Models\CollectData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
// use Excel;
class CollectDataController extends Controller
{
    public function index()
    {
        $fileData = $this->reciveData();
        $allData = CollectData::orderByDesc('id')->paginate(20);
        //  return $fileData;
        return view('fbData.allData', compact('allData'));
    }

    public function collectData()
    {
        // $getData = AllLink::where('check', 'valid')->where('status', 'noaction')->limit(10)->pluck('link')->toArray();
        $getData = AllLink::where('check', 'valid')->where('status', 'noaction')->limit(3)->get();



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
            Log::info('Collect Data ======== ' . $collectData);
        } catch (\Exception $e) {
            Log::error('Error executing Node.js script: ' . $e->getMessage());
        }




        // try {
        //     DatasCollectJob::dispatch($getData);
        //     foreach ($getData as $key => $value) {
        //         AllLink::where('link', '=', $value)->delete();
        //     }
        //     return 'ok';
        // } catch (\Throwable $th) {
        //     throw $th;
        // }
    }
    public function store(Request $request)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    private function reciveData()
    {
        $filesPath = base_path('resources/js/fbData');
        if (File::exists($filesPath)) {
            $fullFilePath = File::files($filesPath);

            array_map(function ($fileCheck) use ($filesPath) {
                $fileName = $fileCheck->getFilename();
                if ($fileName === 'running.json') {
                    return;
                }
                $filePath = $filesPath . DIRECTORY_SEPARATOR . $fileName;
                $fileData = json_decode(File::get($filePath, true));

                if (is_array($fileData)) {
                    $fileInsert = array_map(function ($data) {
                        return [
                            'url' =>   $data->postDetails->url ?? ($data->url ?? 'network error'),
                            'allInfo' => json_encode($data),
                            'user_id' => 1,
                            // 'user_id' => Auth::user()->id,
                        ];
                    }, $fileData);
                    $batchSize = 100;
                    $chunks = array_chunk($fileInsert, $batchSize);
                    foreach ($chunks as $chunk) {
                        CollectData::insert($chunk);
                    }
                } else {
                    return 'File Data Format Wrong';
                }

                File::delete($filePath);

                return 'Success Data Insert';
            }, $fullFilePath);
        } else {
            return 'Already up to date';
        }
    }

    public function multiwork(Request $request)
    {
        $request->validate([
            'action' => 'required|string',
            'multiData' => 'required|array'
        ]);
        $action = $request->action;
        if ($action == 'delete') {
            foreach ($request->multiData as $updateId) {
                CollectData::where('id', $updateId)->delete();
            }
            return redirect()->back()->with('success', 'Data Delerte Sucessful ');
        }
        if ($action == 'complete') {
            foreach ($request->multiData as $updateId) {
                CollectData::where('id', $updateId)->update(['status' => 'complete']);
            }
            return redirect()->back()->with('success', 'Data Update Sucessful ');
        }
    }

    public function exportData()
    {
        return Excel::download(new ExportCollectData, 'collect-data.xlsx');
    }
}
