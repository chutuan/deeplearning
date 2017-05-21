<?php
namespace App\Http\Controllers\Admin;

use App\Repositories\UserRepository;


class DashboardController extends BaseController
{
    public function index()
    {

        return view('admin.dashboard', [
        ]);
    }
}