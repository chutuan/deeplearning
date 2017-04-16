<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\OrderImage;

class OrderImageTransformer extends TransformerAbstract
{

    public function transform(OrderImage $image)
    {
        return [
             'id' => $image->id,
             'thumbnail' => $image->getThumbnail(),
             'original' => $image->getOrigin(),
             'medium' => $image->getMedium()
        ];
    }
}