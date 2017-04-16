<?php
namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class ReviewRepository extends BaseRepository
{
    protected $skipPresenter = true;

    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

    public function presenter()
    {
        return \App\Presenters\ReviewPresenter::class;
    }

    public function  validator()
    {
        return \App\Validators\ReviewValidator::class;
    }

    public function model()
    {
        return \App\Review::class;
    }
}