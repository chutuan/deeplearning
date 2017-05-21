<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiagnoseHistory extends Model
{
    protected $fillable = [
        'user_id', 'symptoms', 'per_cent', 'message', 'advice'
    ];
}
