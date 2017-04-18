<?php
namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class SymptomRepository extends BaseRepository
{
    protected $skipPresenter = true;

    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

    public function presenter()
    {
        return \App\Presenters\SymptomPresenter::class;
    }

    public function  validator()
    {
        return \App\Validators\SymptomValidator::class;
    }

    public function model()
    {
        return \App\Symptom::class;
    }
}