<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Review extends Model implements Presentable
{
    use PresentableTrait;

    protected $fillable = [
        'rating', 'content', 'order_id'
    ];
}
