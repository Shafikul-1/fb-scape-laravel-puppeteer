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
        $allData = CollectData::all();
        // return $allData;
        return view('fbData.allData', compact('allData'));
    }

    public function collectData()
    {
        $jsonFile = base_path('resources/js/fbData.json');
        if (File::exists($jsonFile)) {
            $fbData = json_decode(File::get($jsonFile), true);
            // return $fbData;
            $collectData = array_map(function ($data) {
                return [
                    'url' => $data['postDetails']['url'] ?? 'connecton Error',
                    'allInfo' => json_encode($data),
                    'user_id' => 1,
                    // 'user_id' => Auth::user()->id,
                ];
            }, $fbData);
            $batchSize = 200;
            $chunks = array_chunk($collectData, $batchSize);
            foreach ($chunks as $chunk) {
                CollectData::insert($chunk);
            }
            File::delete($jsonFile);
        }

        //$getData =  AllLink::where('check', '=', 'valid', '&&', 'status', '=', 'noaction')->limit(10)->pluck('link')->toArray();
        $getData = AllLink::where('check', 'valid')
            ->where('status', 'noaction')
            ->limit(10)
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
}
