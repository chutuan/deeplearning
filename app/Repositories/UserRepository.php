<?php
namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityCreated;
use \Prettus\Validator\Contracts\ValidatorInterface;

class UserRepository extends BaseRepository
{
    protected $skipPresenter = true;
    
    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

    public function presenter()
    {
        return \App\Presenters\UserPresenter::class;
    }

    public function  validator()
    {
        return \App\Validators\UserValidator::class;
    }

    public function model()
    {
        return \App\User::class;
    }

    public function create(array $attributes, $rule = ValidatorInterface::RULE_CREATE)
    {
        if (!is_null($this->validator)) {
            $attributes = $this->model->newInstance()->forceFill($attributes)->toArray();
            $this->validator->with($attributes)->passesOrFail($rule);
        }

        $model = $this->model->newInstance($attributes);
        $model->password = bcrypt($model->password);
        $model->generateAccessToken();
        $model->save();
        $this->resetModel();

        event(new RepositoryEntityCreated($this, $model));

        return $this->parserResult($model);
    }

    public function update(array $attributes, $id, $rule = ValidatorInterface::RULE_UPDATE)
    {
        $this->applyScope();

        if (!is_null($this->validator)) {
            // we should pass data that has been casts by the model
            // to make sure data type are same because validator may need to use
            // this data to compare with data that fetch from database.
            $attributes = $this->model->newInstance()->forceFill($attributes)->toArray();

            $this->validator->with($attributes)->setId($id)->passesOrFail($rule);
        }

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        event(new RepositoryEntityUpdated($this, $model));

        return $this->parserResult($model);
    }

    public function loadOrFilter($options)
    {
        $this->scopeQuery(function($query) use ($options)
        {
            if($options['role'] !== null)
            {
                $query = $query->where('role', '=', $options['role']);
            }

            if($options['confirmed'] !== null)
            {
                $query = $query->where('email_confirmed', '=', $options['confirmed']);
            }
            return $query->orderBy('updated_at', 'DESC');
        });

        return $this->all();
    }
}