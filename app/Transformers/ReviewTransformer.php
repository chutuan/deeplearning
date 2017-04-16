<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Review;
use App\Transformers\OrderImageTransformer;

class ReviewTransformer extends TransformerAbstract
{
    public function transform(Review $review)
    {
        return [
             'id' => (int) $review->id,
             'content'   => $review->content,
             'review' => number_format($review->rating, 2)
        ];
    }
}