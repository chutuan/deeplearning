<?php
namespace App\Presenters;

use Prettus\Repository\Presenter\FractalPresenter;

class OrderImagePresenter extends FractalPresenter
{
    // protected $resourceKeyItem = 'order';
    // protected $resourceKeyCollection = 'orders';

    public function getTransformer()
    {
        return new \App\Transformers\OrderImageTransformer;
    }
}