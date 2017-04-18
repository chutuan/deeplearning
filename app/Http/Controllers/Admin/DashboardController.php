<?php
namespace App\Http\Controllers\Admin;

use App\Repositories\UserRepository;


class DashboardController extends BaseController
{
    public function index()
    {
        $userRepository = new UserRepository(app());

        $userRepository->scopeQuery(function($query)
        {
            return $query->whereDate('created_at', '=', date('Y-m-d'));
        });


        $newMembers = count($userRepository->all());

        return view('admin.dashboard', [
            'newMembers' => $newMembers
        ]);
    }
}