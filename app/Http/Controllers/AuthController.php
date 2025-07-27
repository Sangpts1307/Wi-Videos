<?php

namespace App\Http\Controllers;

use App\Factory\Auth\AuthFactory;
use App\Factory\Auth\FacebookAuth;
use App\Factory\Auth\GoogleAuth;
use App\Repositories\Users\UserRepositoryInterface;
use Exception;
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

    //**** 2 function này là riêng của từng trường hợp login, */
    //**** đã refactor lại để phù hợp với tất cả social login bên dưới */
    public function googleLogin(Request $request)
    {
        $param = $request->all();
        $googleAuth = new GoogleAuth();
        try {
            // Get access token from google
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
        } catch(Exception $e) {
            Log::error($e->getMessage());
            return redirect('/login');
        }
    }

    public function facebookLogin(Request $request) 
    {
        $param = $request->all();
        $facebookAuth = new FacebookAuth();
        // $userInfo = $facebookAuth->getUserInfo($param['token']);
        // dd($userInfo);
        try {
            $userInfo = $facebookAuth->getUserInfo($param['token']);
            $email = !isset($userInfo['email']) ? $userInfo['id'] . "@facebook.com" : $userInfo['email'];
            $user = $this->userRepository->findUserUsingEmail($email);
            if (is_null($user)) {
                // Add new user
                $newUserInfo = [
                    'name' => $userInfo['name'],
                    'email' => $email,
                    'avatar' => $userInfo['picture']['data']['url'],
                    'google_id' => '',
                    'facebook_id' => $userInfo['id'],
                ];
                $user = $this->userRepository->create($newUserInfo);
            }
            Auth::login($user);
            return redirect('/home');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect('/login');
        }
    }

    /**
     * Controller method social login
     * 
     * Using code or token and call to Grhap API get user data
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function socialLogin(Request $request, $social) 
    {
        $param = $request->all();
        $authFactory = new AuthFactory();
        $authFactory = $authFactory->make($social);
        try {
            // If google then get access token
            if (!isset($param['token'])) {
                $param['token'] = $authFactory->getAccessToken($param['code']);
            }
            $userInfo = $authFactory->getUserInfo($param['token']);
            $user = $this->userRepository->findUserUsingEmail($userInfo['email']);
            if (is_null($user)) {
                // Add new user
                $newUserInfo = [
                    'name' => $userInfo['name'],
                    'email' => $userInfo['email'],
                    'avatar' => $userInfo['picture'],
                    'google_id' => $userInfo['google_id'] ?? "",
                    'facebook_id' => $userInfo['facebook_id'] ?? "",
                ];
                $user = $this->userRepository->create($newUserInfo);
            }
            Auth::login($user);
            return redirect('/home');
        } catch (\Exception $exception) {
            Log::error($exception);
            return redirect('/login');
        }
    }

    /**
     * Controller method logout
     * 
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect('/login');
    }

}
