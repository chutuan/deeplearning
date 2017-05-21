<?php
namespace App\Presenters;

use Prettus\Repository\Presenter\FractalPresenter;

class HistoryPresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return new \App\Transformers\HistoryTransformer;
    }
}