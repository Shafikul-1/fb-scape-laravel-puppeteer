<?php

namespace App\Http\Controllers;

use App\Models\AllLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allLinks = AllLink::paginate(20);
        return view('fbData.allLink', compact('allLinks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fbData.inputLink');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'links' => 'required|string'
        ]);

        $allLinks = explode(' ', $request->links);
        $filterArray = array_filter($allLinks, function ($value) {
            return !empty($value);
        });

        function checkLink($link)
        {
            return Str::startsWith($link, ['https://', 'http://']) ? 'valid' : 'invalid';
        }

        $data = array_map(function ($link) {
            return [
                'link' => $link,
                'status' => 'noaction',
                'check' => checkLink($link),
                'user_id' => Auth::user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $filterArray);

        $batchSize = 200;
        $chunks = array_chunk($data, $batchSize);
        // return $chunks;
        foreach ($chunks as $chunk) {
            AllLink::insert($chunk);
        }

        return redirect()->route('link.index')->with('success', 'Link Added Successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteLink = AllLink::find($id)->delete();
        return $deleteLink ? redirect()->back()->with('success', 'link delete succesful') : redirect()->back()->with('error', 'Someting went wrong');
    }

    // Multi work
    public function multiwork(Request $request)
    {
        return $request;
        // $deleteLink = AllLink::find($id)->delete();
        // return $deleteLink ? redirect()->back()->with('success', 'link delete succesful') : redirect()->back()->with('error', 'Someting went wrong');
    }

    public function linkDelete()
    {
        $deleteData = AllLink::where('status', 'pending')->delete();
        if ($deleteData) {
            return 'delete Successfull';
        } else {
            return 'delete Failed';
        }
    }
}
