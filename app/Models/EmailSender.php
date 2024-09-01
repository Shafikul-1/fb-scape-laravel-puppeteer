<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSender extends Model
{
    use HasFactory;

    // public function emailData(){
    //     return $this->belongsToMany( User::class, 'email_data', 'user_id', 'email_sender_id' );
    // }
}
