<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnose extends Model
{
    protected $table = "diagnosis";
    protected $fillable = [
        'symptoms', 'result'
    ];
}
