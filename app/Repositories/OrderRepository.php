<?php
namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class OrderRepository extends BaseRepository
{
    protected $skipPresenter = true;

    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

    public function presenter()
    {
        return \App\Presenters\OrderPresenter::class;
    }

    public function  validator()
    {
        return \App\Validators\OrderValidator::class;
    }

    public function model()
    {
        return \App\Order::class;
    }

    public function loadOrFilter($options)
    {
        $this->scopeQuery(function($query) use ($options)
        {
            if(isset($options['status']))
            {
                $query = $query->where('status', '=', $options['status'])->orderBy('updated_at', 'DESC');
            }
            return $query;
        });

        return $this->all();
    }
}