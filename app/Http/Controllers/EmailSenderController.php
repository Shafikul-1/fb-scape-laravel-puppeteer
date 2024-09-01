<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\EmailSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailSenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('email.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('random_time')) {
            $request->validate([
                'schedule_time' => ['required', 'regex:/^\d+,\d+$/'],
            ]);
        }
        if (!$request->has('random_time')) {
            $request->validate([
                'schedule_time' => 'required|integer|min:10',
            ]);
        }

        $request->validate([
            'email' => 'required|string',
            'email_subject' => 'required',
            'email_body' => 'required',
            'sending_time' => 'required|date_format:Y-m-d\TH:i',
            'email_files' => 'required|file|mimes:jpg,png,pdf|max:2048',

        ]);

        $allEmails = explode(' ', $request->email);
        $filterEmails = array_filter($allEmails, fn($value) => !empty($value) && strpos($value, '@') !== false);

        $currentTime = now();
        $storeData = [];
        foreach($filterEmails as $email){
            $newTime = null;
            if ($request->has('random_time')) {
                $randomTime = explode(',', $request->sending_time);
                $randomSelect = array_rand($randomTime);
                $newTime = $currentTime->addMinutes($randomTime[$randomSelect]);
            } else {
                $newTime = $currentTime->addMinutes($request->sending_time);
            }

            $storeData[] = [
                'email' => $email,
                'email_subject' => $request->email_subject,
                'email_body' => $request->email_body,
                'sending_time' => $newTime,
                'email_files' => $request->email_files,
                'user_id' => Auth::user()->id,
            ];
        }
return $storeData;
        if(EmailSender::insert($storeData)){
            return 'Ok sent';
        } else{
            return 'somentin';
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $singleData = EmailSender::find($id);
        return view('email.edit', compact('singleData'));
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
        //
    }
}
