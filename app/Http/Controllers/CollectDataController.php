<?php

namespace App\Http\Controllers;

use App\Models\AllLink;
use App\Models\CollectData;
use Illuminate\Http\Request;
use App\Jobs\DatasCollectJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CollectDataController extends Controller
{
    public function index()
    {
        $allData = CollectData::orderByDesc('id')->paginate(20);
        // return $allData;
        return view('fbData.allData', compact('allData'));
    }

    public function collectData()
    {

        //$getData =  AllLink::where('check', '=', 'valid', '&&', 'status', '=', 'noaction')->limit(10)->pluck('link')->toArray();
        $getData = AllLink::where('check', 'valid')
            ->where('status', 'noaction')
            ->limit(3)
            ->pluck('link')
            ->toArray();

        try {
            DatasCollectJob::dispatch($getData);
            foreach ($getData as $key => $value) {
                AllLink::where('link', '=', $value)->delete();
            }
            return 'ok';
        } catch (\Throwable $th) {
            throw $th;
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
            $files = File::files($filesPath);

            array_map(function ($file) use ($filesPath) {
                $fileName = $file->getFilename();
                if($fileName === 'running.json'){
                    return;
                }
                $filePath = $filesPath . DIRECTORY_SEPARATOR . $fileName;
                $fileData = json_decode(File::get($filePath, true));
                if (is_array($fileData)) {
                    $fileInsert = array_map(function ($data) {
                        return [
                            'url' => $data->postDetails->url,
                            'allInfo' => json_encode($data),
                            'user_id' => 1,
                            // 'user_id' => Auth::user()->id,
                        ];
                    }, $fileData);
                    $batchSize = 10;
                    $chunks = array_chunk($fileInsert, $batchSize);
                    foreach ($chunks as $chunk) {
                        CollectData::insert($chunk);
                    }
                } else{
                    return 'File Data Format Wrong';
                }

                File::delete($filePath);

                return 'Success Data Insert';
            }, $files);
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
}
