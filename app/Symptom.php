<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    protected $fillable = [
        'symptom_id', 'sort', 'content'
    ];

    public function symptoms()
    {
        return $this->hasMany(\App\Symptom::class);
    }
}
