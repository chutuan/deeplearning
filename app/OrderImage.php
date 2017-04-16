<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class OrderImage extends Model implements Presentable
{
    use PresentableTrait;

    protected $fillable = [
        'name', 'type', 'size', 'order_id'
    ];

    public function getThumbnail()
    {
        $path = '/orders/thumbnail_' . $this->name;
        if(!file_exists(public_path($path)))
        {
            \Image::make(public_path('/orders/') . $this->name)->resize(640, 360)
                ->save(public_path($path));
        }
        return asset($path);
    }

    public function getOrigin()
    {
        return asset('/orders/' . $this->name);
    }

    public function getMedium()
    {
        $path = '/orders/medium_' . $this->name;
        if(!file_exists(public_path($path)))
        {
            \Image::make(public_path('/orders/') . $this->name)->resize(1024, 768)
                ->save(public_path($path));
        }
        return asset($path);
    }
}
