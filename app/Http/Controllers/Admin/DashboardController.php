<?php
namespace App\Http\Controllers\Admin;

use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;

class DashboardController extends BaseController
{
    public function index()
    {
        $userRepository = new UserRepository(app());
        $orderRepository = new OrderRepository(app());

        $userRepository->scopeQuery(function($query)
        {
            return $query->whereDate('created_at', '=', date('Y-m-d'));
        });

        $orderRepository->scopeQuery(function($query)
        {
            return $query->orderBy('updated_at', 'DESC')->take(10);
        });

        $newMembers = count($userRepository->all());
        $orders = $orderRepository->all();

        $pendingOrders = count($orderRepository->findByField('status', \App\Order::STATUS_NEW));
        $deliveryOrders = count($orderRepository->findByField('status', \App\Order::STATUS_CLEANED));

        return view('admin.dashboard', [
            'newMembers' => $newMembers,
            'orders' => $orders,
            'pendingOrders' => $pendingOrders,
            'deliveryOrders' => $deliveryOrders
        ]);
    }
}