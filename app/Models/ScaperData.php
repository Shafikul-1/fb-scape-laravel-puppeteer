<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScaperData extends Model
{
    use HasFactory;
    protected $table = 'scaper_datas';
    protected $guarded = [];
}
