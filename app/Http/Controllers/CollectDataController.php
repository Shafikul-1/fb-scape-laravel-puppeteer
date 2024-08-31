<?php

namespace App\Http\Controllers;

use App\Models\AllLink;
use App\Models\CollectData;
use Illuminate\Http\Request;
use App\Jobs\DatasCollectJob;
use App\Exports\ExportCollectData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
// use Excel;
class CollectDataController extends Controller
{
    public function index()
    {
        $allData = CollectData::where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(20);
        //  return $fileData;
        return view('fbData.allData', compact('allData'));
    }

    public function collectData()
    {
        // set_time_limit(200);
        // $getData = AllLink::where('check', 'valid')->where('status', 'noaction')->limit(10)->pluck('link')->toArray();
        $getData = AllLink::where('check', 'valid')->where('status', 'noaction')->limit(3)->get();
        if (!$getData->isEmpty()) {
            try {
                DatasCollectJob::dispatch($getData);
                foreach ($getData as $key => $value) {
                    AllLink::where('link', '=', $value)->delete();
                }
                return 'ok';
            } catch (\Throwable $th) {
                Log::error('CollectData Error : ' . $th->getMessage());
            }
        }
    }
    public function store(Request $request)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function reciveData()
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
                            'url' => $data->basicData->url ?? 'N/A',
                            'allInfo' => json_encode($data),
                            'user_id' => $data->basicData->user_id ?? 1,
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
