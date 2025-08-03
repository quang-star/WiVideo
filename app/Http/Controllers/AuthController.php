<?php

namespace App\Http\Controllers;

use App\Factory\Auth\AuthFactory;
use App\Factory\Auth\FacebookAuth;
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
    ) {
        $this->userRepository = $userRepositoryInterface;
    }

    public function login()
    {
        return view('login');
    }
    /**
     * Controller method logout user
     * 
     * If user is logged in, log them out and redirect to login page
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        if(Auth::check()) {
            // If user is logged in, log them out
            Auth::logout();
        }
        return redirect('/login');
    }


    /**
     * Contrler method social login
     * 
     * Using code or token and call to Grhap API get user data
     * @param \Illuminate\Http\Request $request
     * @param mixed $social
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function socialLogin(Request $request, $social)
    {

        $param = $request->all();
        // dd($param);
        $authFactory = new AuthFactory();
        $authFactory = $authFactory->make($social);

        try {
            //if google then get token
            if (!isset($param['token'])) {
                $param['token'] = $authFactory->getAccessToken($param['code']);
            }
            $userInfo = $authFactory->getUserInfo($param['token']);

            //    $email = !isset($userInfo['email']) ? $userInfo['id']."@facebook.com" : $userInfo['email'];
            $user = $this->userRepository->findUserUsingEmail($userInfo['email']);
            //   dd($user);
            //   dd($userInfo);
            if (is_null($user)) {
                // Add new user
                $newUserInfo = [
                    'name' => $userInfo['name'],
                    'email' => $userInfo['email'],
                    'avatar' => $userInfo['picture'],
                    'google_id' => $userInfo['google_id'] ?? '',
                    'facebook_id' => $userInfo['facebook_id'] ?? ''
                ];
                $user = $this->userRepository->create($newUserInfo);
            }
            // dd($userInfo);
            Auth::login($user);
            return redirect('/home');
        } catch (\Exception $e) {
            Log::error($e);
         //   dd($e);
            return redirect('/login');
        }
    }
}
