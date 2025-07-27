<?php

namespace App\Repositories\Users;

interface UserRepositoryInterface
{
    // Define function get user using email
    public function findUserUsingEmail($email);

    // Define function get my info
    public function getMyInfo($userId);
}