<?php
namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class HistoryRepository extends BaseRepository
{
    protected $skipPresenter = true;

    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

    public function presenter()
    {
        return \App\Presenters\HistoryPresenter::class;
    }

    public function  validator()
    {
        // return \App\Validators\ReviewValidator::class;
    }

    public function model()
    {
        return \App\DiagnoseHistory::class;
    }
}