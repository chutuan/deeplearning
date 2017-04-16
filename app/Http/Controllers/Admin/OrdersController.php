<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Task;

class OrdersController extends Controller
{
    protected $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index(Request $request)
    {
        $orders = $this->repository->loadOrFilter($request->all());
        return view('admin.orders.index', [
            'orders' => $orders
        ]);
    }

    public function pendingPickups()
    {
        $orders = $this->repository->loadOrFilter(['status' => \App\Order::STATUS_NEW]);
        $userRepository = new UserRepository(app());
        $drivers = $userRepository->findByField('role', \App\User::ROLE_DRIVER);
        return view('admin.orders.pending-pickup', [
            'orders' => $orders,
            'drivers' => $drivers
        ]);
    }

    public function picking()
    {
        $orders = $this->repository->loadOrFilter(['status' => \App\Order::STATUS_READY_PICKUP]);
        return view('admin.orders.ready-pickup', [
            'orders' => $orders
        ]);
    }

    public function pendingDeliveries()
    {
        $orders = $this->repository->loadOrFilter(['status' => \App\Order::STATUS_CLEANED]);
        $userRepository = new UserRepository(app());
        $drivers = $userRepository->findByField('role', \App\User::ROLE_DRIVER);
        return view('admin.orders.pending-delivery', [
            'orders' => $orders,
            'drivers' => $drivers
        ]);
    }

    public function assignPickup(Request $request, $orderId)
    {
        $order = $this->repository->findByField('id', $orderId)->first();
        if($request->get('employee_id') && $order)
        {
            $task = Task::where('order_id', $orderId)->where('action', Task::ACTION_PICKUP)->first();
            if(!$task)
            {
                $task = Task::create([
                    'order_id' => $orderId,
                    'action' => Task::ACTION_PICKUP
                ]);
            }
            if($task)
            {
                $task->update([
                    'user_id' => $request->get('employee_id'),
                    'created_by' => \Auth::user()->id
                ]);
                $order->update([
                    'status' => \App\Order::STATUS_READY_PICKUP
                ]);
            }
            \Session::flash('success', 'Assign Successfully');
        }else
        {
            \Session::flash('error', 'Employee can\'t empty!');
        }

        return redirect('/admin/orders/pending-pickups');
    }

    public function getCleaneds()
    {
        $orders = $this->repository->loadOrFilter(['status' => \App\Order::STATUS_PICKEDUP]);
        return view('admin.orders.picked-up', [
            'orders' => $orders
        ]);
    }

    public function cancelPickup(Request $request, $orderId)
    {
        $order = $this->repository->findByField('id', $orderId)->first();
        if($order)
        {
            $order->update(['status' => \App\Order::STATUS_NEW]);

            // Clear Task
            $task = Task::where('order_id', $orderId)->where('action', Task::ACTION_PICKUP)->first();
            Task::destroy($task->id);
            \Session::flash('success', 'Cancel Successfully');
        }
        return redirect('/admin/orders/picking');
    }

    public function cleaned(Request $request, $orderId)
    {
        $order = $this->repository->findByField('id', $orderId)->first();
        if($order)
        {
            $order->update([
                'status' => \App\Order::STATUS_CLEANED,
                'cleaned_at' => date('Y-m-d H:i:s')
            ]);
            \Session::flash('success', 'Clean Successfully');
        }
        return redirect('/admin/orders/cleaneds');
    }

    public function assignDelivery(Request $request, $orderId)
    {
        $order = $this->repository->findByField('id', $orderId)->first();
        if($request->get('employee_id') && $order)
        {
            $task = Task::where('order_id', $orderId)->where('action', Task::ACTION_DELIVERY)->first();
            if(!$task)
            {
                $task = Task::create([
                    'order_id' => $orderId,
                    'action' => Task::ACTION_DELIVERY
                ]);
            }
            if($task)
            {
                $task->update([
                    'user_id' => $request->get('employee_id'),
                    'created_by' => \Auth::user()->id
                ]);
                $order->update([
                    'status' => \App\Order::STATUS_READY_DELIVERY
                ]);
            }
            \Session::flash('success', 'Assign Successfully');
        }else
        {
            \Session::flash('error', 'Employee can\'t empty!');
        }

        return redirect('/admin/orders/pending-deliveries');
    }

    public function getReadyDeliveries()
    {
        $orders = $this->repository->loadOrFilter(['status' => \App\Order::STATUS_READY_DELIVERY]);
        return view('admin.orders.ready-delivery', [
            'orders' => $orders
        ]);
    }

    public function cancelDelivery(Request $request, $orderId)
    {
        $order = $this->repository->findByField('id', $orderId)->first();
        if($order)
        {
            $order->update(['status' => \App\Order::STATUS_CLEANED]);

            // Clear Task
            $task = Task::where('order_id', $orderId)->where('action', Task::ACTION_DELIVERY)->first();
            Task::destroy($task->id);
            \Session::flash('success', 'Cancel Successfully');
        }
        return redirect('/admin/orders/cleaneds');
    }

    public function getComplete()
    {
        $orders = $this->repository->loadOrFilter(['status' => \App\Order::STATUS_DELIVERED]);
        return view('admin.orders.complete', [
            'orders' => $orders
        ]);
    }
}