<?php
namespace App\Http\Controllers\Api\V1;

use App\Repositories\ReviewRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use \Prettus\Validator\Exceptions\ValidatorException;

class ReviewsController extends BaseController
{
    protected $repository;

    public function __construct(ReviewRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        try
        {
            $params = $request->all();
            $orderRepository = new OrderRepository(app());
            $order = $orderRepository->findByField('id', $params['order_id'])->first();
            if($order)
            {
                $review = $this->repository->create($params);
            }else
            {
                return $this->responseError('Order Not Found');
            }
            return $this->responseSuccess('Create Successfully', ['review' => $review->presenter()]);
        } catch(ValidatorException $e)
        {
            return $this->responseError('Create Failed', $e->getMessageBag());
        }
    }
}