<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Order;
use App\Transformers\OrderImageTransformer;

class OrderTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'images'
    ];

    public function transform(Order $order)
    {
        return [
             'id' => (int) $order->id,
             'name'   => $order->name,
             'address' => $order->address,
             'weight' => $order->weight,
             'unit_price' => $order->unit_price,
             'pickup_at' => $order->pickup_at ? $order->pickup_at->format('c') : null,
             'delivered_at' => $order->delivered_at,
             'cleaned_at' => $order->cleaned_at,
             'created_at' => $order->created_at->format('c'),
             'updated_at' => $order->updated_at->format('c'),
             'status' => $order->status
        ];
    }

    public function includeImages(Order $order)
    {
        return $this->collection($order->images, new OrderImageTransformer, 'images');
    }
}