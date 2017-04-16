<?php
namespace App\Http\Controllers\Api\V1;

use App\Repositories\OrderRepository;
use App\Repositories\OrderImageRepository;
use Illuminate\Http\Request;
use \Prettus\Validator\Exceptions\ValidatorException;
use App\Task;

class OrdersController extends BaseController
{
    protected $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $this->repository->skipPresenter(false)->with('images')->scopeQuery(function($query)
        {
            return $query->where('user_id', '=', \Auth::user()->id)->orderBy('created_at', 'DESC');
        });
        $orders = $this->repository->all();

        return $this->responseSuccess('Get Successfully', ['orders' => $orders]);
    }

    public function show($id)
    {
        $order = $this->repository->with('images')->find($id);
        if($order)
        {
            return $this->responseSuccess('Get Successfully', ['order' => $order->presenter()]);
        }else
        {
            return $this->responseError('Not Found');
        }
    }

    public function store(Request $request)
    {
        try
        {
            $orderImageRepository = new OrderImageRepository(app());
            $params = $request->all();
            $params['user_id'] = \Auth::user()->id;
            $params['status'] = \App\Order::STATUS_NEW;
            $order = $this->repository->create($params);
            if (!file_exists(public_path('/orders/'))) {
                mkdir(public_path('/orders/'));
            }
            foreach($params['images'] as $key => $image)
            {
                $name = md5($order->id) . '_' . md5($key) . '.' . $image->getClientOriginalExtension();
                \Image::make($image)->save(public_path('/orders/' . $name));
                $orderImageRepository->create([
                    'type' => $image->getMimeType(),
                    'name' => $name,
                    'size' => $image->getClientSize(),
                    'order_id' => $order->id
                ]);
            }
            return $this->responseSuccess('Create Successfully', ['order' => $order->presenter()]);
        } catch(ValidatorException $e)
        {
            return $this->responseError('Create Failed', $e->getMessageBag());
        }
    }

    public function pickedUp($orderId)
    {
        $order = $this->repository->with('images')->find($orderId);

        // Check Order Status
        if(!$order || $order && $order->status !== \App\Order::STATUS_READY_PICKUP)
        {
            return $this->responseError('This Order Not Ready For Pick-up');
        }
        // Check Order Is Assign To Driver
        $task = Task::where('order_id', $orderId)->where('action', Task::ACTION_PICKUP)
            ->where('user_id', \Auth::user()->id)->first();
        if(!$task)
        {
            return $this->responseError('You Don\'t Have Permission To Pick-up This Order');
        }

        $order->update([
            'picked_at' => date('Y-m-d H:i:s'),
            'status' => \App\Order::STATUS_PICKEDUP
        ]);
        return $this->responseSuccess('Pick-up Successfully', ['order' => $order->presenter()]);
    }

    public function delivered($orderId)
    {
        $order = $this->repository->with('images')->find($orderId);

        // Check Order Status
        if(!$order || $order && $order->status !== \App\Order::STATUS_READY_DELIVERY)
        {
            return $this->responseError('This Order Not Ready For Delivery');
        }
        // Check Order Is Assign To Driver
        $task = Task::where('order_id', $orderId)->where('action', Task::ACTION_DELIVERY)
            ->where('user_id', \Auth::user()->id)->first();
        if(!$task)
        {
            return $this->responseError('You Don\'t Have Permission To Delivery This Order');
        }

        $order->update([
            'delivered_at' => date('Y-m-d H:i:s'),
            'status' => \App\Order::STATUS_DELIVERED
        ]);
        return $this->responseSuccess('Delivery Successfully', ['order' => $order->presenter()]);
    }

    public function getPickUps()
    {
         $this->repository->skipPresenter(false)->with('images')->scopeQuery(function($query)
        {
            return $query->join('tasks', 'tasks.order_id', '=', 'orders.id')
                ->where('tasks.user_id', '=', \Auth::user()->id)
                ->where('tasks.action', '=', \App\Task::ACTION_PICKUP)
                ->where('status', '=', \App\Order::STATUS_READY_PICKUP)->orderBy('orders.updated_at', 'DESC');
        });
        $orders = $this->repository->all();

        return $this->responseSuccess('Get Successfully', ['orders' => $orders]);
    }

    public function getDeliveries()
    {
         $this->repository->skipPresenter(false)->with('images')->scopeQuery(function($query)
        {
            return $query->join('tasks', 'tasks.order_id', '=', 'orders.id')
                ->where('tasks.user_id', '=', \Auth::user()->id)
                ->where('tasks.action', '=', \App\Task::ACTION_DELIVERY)
                ->where('status', '=', \App\Order::STATUS_READY_DELIVERY)->orderBy('orders.updated_at', 'DESC');
        });
        $orders = $this->repository->all();

        return $this->responseSuccess('Get Successfully', ['orders' => $orders]);
    }
}