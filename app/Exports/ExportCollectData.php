<?php

namespace App\Exports;

use App\Models\CollectData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportCollectData implements FromCollection, WithHeadings, WithMapping // Implement the interfaces
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return CollectData::where('user_id', Auth::user()->id)->get();
    }

    public function map($data): array
    {
        $correctionNumber = 'N/A';
        $whatsApp = 'N/A';
        $number = $data->allInfo['contactDetails']['Mobile'] ?? 'N/A';
        if ($number != 'N/A') {
            if (Str::startsWith($number, '+')) {
                $correctionNumber = substr($number, 1);
            } else{
                $correctionNumber = $number;
            }
            $createCorrectNumber = preg_replace('/\D/', '', $number);
            $whatsApp = 'https://wa.me/+' . $createCorrectNumber;
        }

        return [
            $data->id ?? 'N/A',
            $data->url ?? 'N/A',
            $data->allInfo['contactDetails']['Address'] ?? 'N/A',
            $data->allInfo['contactDetails']['Website'] ?? 'N/A',
            $data->allInfo['contactDetails']['Email'] ?? 'N/A',
            $correctionNumber,
            $whatsApp,
            $data->allInfo['postDetails']['name'] ?? 'N/A',
            $data->allInfo['postDetails']['timeText'] ?? 'N/A',
            $data->allInfo['contactDetails']['Instagram'] ?? 'N/A',
            // $data->user_id ?? 'N/A',
            // $data->status ?? 'N/A',
        ];
    }

    /**
     * Define the headings for the columns.
     */
    public function headings(): array
    {
        return [
            'ID',
            'URL',
            'Post Address',
            'Website',
            'Email',
            'Mobile',
            'WhatsApp',
            'Page Name',
            'Post Time',
            'Social',
            // 'User ID',
            // 'Details Status',
        ];
    }
}
