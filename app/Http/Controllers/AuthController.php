<?php

namespace App\Http\Controllers;

use App\Factory\Auth\GoogleAuth;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepositoryInterface
    )
    {
        $this->userRepository = $userRepositoryInterface;
    }

    public function login() {
        return view('login');
    }

    /**
     * Controller method google login
     * 
     * Using code and call to Grhap API
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function googleLogin(Request $request)
    {
        $param = $request->all();
      //  dd($param);
        $googleAuth = new GoogleAuth();
        //$accessToken = $googleAuth->getAccessToken($param['code']);
    //    / dd($accessToken);
        try {
            // Get access token from Google
            $accessToken = $googleAuth->getAccessToken($param['code']);
            $userInfo = $googleAuth->getUserInfo($accessToken);
            // Check user info in DB
            $user = $this->userRepository->findUserUsingEmail($userInfo['email']);
            // User has ready, create session and go to home page.
            if (is_null($user)) {
                // Add new user
                $newUserInfo = [
                    'name' => $userInfo['name'],
                    'email' => $userInfo['email'],
                    'avatar' => $userInfo['picture'],
                    'google_id' => '',
                    'facebook_id' => ''
                ];
                $user = $this->userRepository->create($newUserInfo);
            }
            Auth::login($user);
            return redirect('/home');
            
            


        } catch (\Exception $e) {
           // dd($e->getMessage());
           Log::error($e->getMessage());
            return redirect('/login');
        }
      
       

    }
}