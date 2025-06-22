<?php

namespace App\Http\Controllers;

use App\Repositories\Users\UserEloquentRepository;
use Illuminate\Http\Request;

class TestView extends Controller
{
    // Define module repository
    private $userRepository;

    public function __construct(UserEloquentRepository $userEloquentRepository)
    {
        $this->userRepository = $userEloquentRepository;
    }

    public function test()
    {
        $users = $this->userRepository->getAll();
        return [
            "code" => 200,
            "message" => "success",
            "data" => $users
        ];
    }
}
