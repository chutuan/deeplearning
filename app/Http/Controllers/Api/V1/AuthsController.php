<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use \Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;

class AuthsController extends BaseController
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(Request $request)
    {
        if(\Auth::attempt($request->only('email', 'password')))
        {
            $user = $this->repository->find(\Auth::user()->id);
            $user->generateAccessToken();
            $user->save();

            return $this->responseSuccess('Login Successfully', ['user' =>$user->presenter()]);
        }else
        {
            return $this->responseError('Email or Password invalid', null, 401);
        }
    }

    public function facebook(Request $request)
    {
        $fb = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.5',
        ]);
        $access_token = $request->get("token");
        $fb->setDefaultAccessToken($access_token);

        try {
            $response = $fb->get('/me?fields=first_name,last_name,gender,email');
            $userNode = $response->getGraphUser();
            $user = $this->repository->findByField('email', $userNode->getEmail())->first();
            if(!$user)
            {
                $user = $this->repository->create([
                    'facebook_id' => $userNode->getId(),
                    'first_name' => $userNode->getFirstName(),
                    'last_name' => $userNode->getLastName(),
                    'email' => $userNode->getEmail(),
                    'email_confirmed' => true
                ], UserValidator::RULE_LOGIN_FACEBOOK);
            }else
            {
                $user->facebook_id = $userNode->getId();
                $user->generateAccessToken();
                $user->save();
            }

            return $this->responseSuccess('Login Successfully', ['user' =>$user->presenter()]);
        } catch(ValidatorException $e) {
        } catch(\Exception $e) {
        } 
        return $this->responseError('Token invalid', null, 401);
    }

    public function gmail(Request $request)
    {
        // $accessToken = $request->get('token');
        // $client = new \Google_Client();
        // $client->setClientId(env('OAUTH_CLIENT_ID'));
        // $client->setClientSecret(env('OAUTH_CLIENT_SECRET'));
        // $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
        // $client->addScope("https://www.googleapis.com/auth/userinfo.email");
        // $client->setRedirectUri("http://abriotools-dev.com:2016/login.php");
        // $client->authenticate($accessToken);
        // $user = new \Google_Service_Oauth2($client);
        // $userInfo = $user->userinfo->get();
        // var_dump($userInfo); die();
        echo "Working on it";
    }

    public function logout()
    {
        \Auth::user()->update(['access_token' => null]);
        return $this->responseSuccess('Logout Successfully');
    }
}