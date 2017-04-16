<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Task extends Model implements Presentable
{
    const ACTION_PICKUP = 'pickup';
    const ACTION_DELIVERY = 'delivery';

    use PresentableTrait;

    protected $fillable = [
        'user_id', 'order_id', 'created_by', 'action'
    ];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }
}
