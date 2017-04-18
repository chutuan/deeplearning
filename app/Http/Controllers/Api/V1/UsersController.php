<?php
namespace App\Http\Controllers\Api\V1;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use \Prettus\Validator\Exceptions\ValidatorException;
use App\Validators\UserValidator;
use App\Mail\EmailConfirmed;
use App\User;

class UsersController extends BaseController
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $users = $this->repository->all();
        echo json_encode($users);
    }

    public function store(Request $request)
    {
        try
        {
            $params = $request->all();
            $params['confirmation_code'] = User::generateConfirmationCode();
            $user = $this->repository->create($params);

            return $this->responseSuccess('Create Successfully', ['user' => $user->presenter()]);
        } catch(ValidatorException $e)
        {
            return $this->responseError('Create Failed', $e->getMessageBag());
        }
    }

    public function changePassword(Request $request)
    {
        try
        {
            if(\Hash::check($request->get('old_password'), \Auth::user()->password))
            {
                $this->repository->makeValidator()->with($request->all())->passesOrFail(UserValidator::RULE_RESET_PASSWORD);
                \Auth::user()->updatePassword($request['password']);
                return $this->responseSuccess('Update Successfully', ['user' => \Auth::user()->presenter()]);
            }else
            {
                return $this->responseError('Old Password Is Invalid', ['old_password' => ['Old Password Invalid']]);
            }
        } catch(ValidatorException $e)
        {
            return $this->responseError('Update Failed', $e->getMessageBag());
        }
    }

    public function me()
    {
        return $this->responseSuccess('Get Successfully', ['user' => \Auth::user()->presenter()]);
    }

    public function verify(Request $request)
    {
        $token = $request->get('token');
        if(\Auth::user()->confirmation_code === $token)
        {
            \Auth::user()->update([
                'confirmation_code' => null,
                'email_confirmed' => 1
            ]);
            return $this->responseSuccess('Verify Successfully', ['user' => \Auth::user()->presenter()]);
        }else
        {
            return $this->responseError('Token Invalid!');
        }
    }

    public function changeAvatar(Request $request)
    {
        $image = $request->file('avatar');
        if(!$image || $image && array_search($image->getMimeType(), ['image/png', 'image/jpeg']) === false)
        {
            return $this->responseError('Image Invalid!');
        }
        $name = '/avatars/' . md5(\Auth::user()->id) . '.' . strtolower($image->getClientOriginalExtension());
        \Image::make($image)->save(public_path($name));
        \Auth::user()->update([
            'avatar' => $name
        ]);
        \Auth::user()->avatar = $name;
        return $this->responseSuccess('Update Successfully', ['user' => \Auth::user()->presenter()]); 
    }
}