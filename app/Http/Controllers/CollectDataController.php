<?php

namespace App\Http\Controllers;

use App\Models\CollectData;
use Illuminate\Http\Request;

class CollectDataController extends Controller
{
    public function index(){
        $allData = CollectData::all();
        return view('fbData.allData', compact('allData'));
    }

    public function collectData(){

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
