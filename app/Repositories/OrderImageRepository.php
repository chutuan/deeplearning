<?php
namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class OrderImageRepository extends BaseRepository
{
    protected $skipPresenter = true;
    
    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

    public function presenter()
    {
        return \App\Presenters\OrderImagePresenter::class;
    }

    public function  validator()
    {
        return \App\Validators\OrderImageValidator::class;
    }

    public function model()
    {
        return \App\OrderImage::class;
    }
}