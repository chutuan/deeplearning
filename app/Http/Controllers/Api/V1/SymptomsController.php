<?php
namespace App\Http\Controllers\Api\V1;

use App\Repositories\SymptomRepository;
use Illuminate\Http\Request;
use \Prettus\Validator\Exceptions\ValidatorException;
use App\Task;

class SymptomsController extends BaseController
{
    protected $repository;

    public function __construct(SymptomRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $this->repository->skipPresenter(false)->with('symptoms')->scopeQuery(function($query)
        {
            return $query->whereNull('symptom_id');
        });
        $symptoms = $this->repository->all();

        return $this->responseSuccess('Get Successfully', ['symptoms' => $symptoms]);
    }

}