<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;
use App\Task;

class Order extends Model implements Presentable
{
    const STATUS_NEW = "Awaiting pick up confirmation";
    const STATUS_READY_PICKUP = "Ready for pick-up";
    const STATUS_PICKEDUP = "Picked-up";
    const STATUS_CLEANED = "Cleaned";
    const STATUS_READY_DELIVERY = "Ready for delivery";
    const STATUS_DELIVERED = "Delivered";

    use PresentableTrait;

     protected $dates = [
        'created_at',
        'updated_at',
        'pickup_at',
        'picked_at',
        'cleaned_at',
        'delivered_at'
    ];

    protected $attributes = array(
        'weight' => 0,
        'unit_price' => 0
    );

    protected $fillable = [
        'name', 'address', 'weight', 'unit_price', 'pickup_at', 'delivered_at', 'cleaned_at', 'user_id', 'status',
        'picked_at'
    ];

    // Relationship
    public function owner()
    {
        return $this->belongsTo('\App\User', 'user_id');
    }
    public function images()
    {
        return $this->hasMany(\App\OrderImage::class);
    }

    public function picker()
    {
        return Task::where('order_id', $this->id)->where('action', Task::ACTION_PICKUP)->first();
    }
}