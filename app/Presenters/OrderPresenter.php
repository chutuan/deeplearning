<?php
namespace App\Presenters;

use Prettus\Repository\Presenter\FractalPresenter;
use League\Fractal\Serializer\ArraySerializer;

class OrderPresenter extends FractalPresenter
{
    // protected $resourceKeyItem = 'order';
    // protected $resourceKeyCollection = 'orders';

    public function __construct()
    {
        parent::__construct();
        $this->fractal->parseIncludes($this->getTransformer()->getAvailableIncludes());
    }


    public function getTransformer()
    {
        return new \App\Transformers\OrderTransformer;
    }

}