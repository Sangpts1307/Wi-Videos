<?php

namespace App\Http\Controllers;

use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Controller method render home view blade
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory\Iluminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $user = $this->userRepository->getMyInfo(Auth::user()->id);
        return view('home', compact('user'));
    }
}
