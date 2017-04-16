<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $options = [
            'role' => null !== $request->get('role') ? $request->get('role') : null,
            'confirmed' => null !== $request->get('confirmed') ? $request->get('confirmed') : null
        ];
        $users = $this->repository->loadOrFilter($options);
        return view('admin.users.index', [
            'users' => $users,
            'options' => $options
        ]);
    }

    public function setRole(Request $request, $userId)
    {
        $user = $this->repository->find($userId);
        if($user->role != $request->get('role'))
        {
            $user->update([
                'role' => $request->get('role')
            ]);
        }

        \Session::flash('success', 'Update Successfully');
        return redirect('/admin/users');
    }
}