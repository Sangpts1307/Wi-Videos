<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{
    /**
     * Implement abstract method and base model
     *
     * @return mixed | model
     */
    public function getModel()
    {
        return User::class;
    }

    /**
     * Implement method find user using email
     * 
     * @param mixed $email
     * @return null | Collection user
     */
    public function findUserUsingEmail($email)
    {
        return $this->_model->where('email', $email)->first();
    }

    /**
     * Repository method get user info
     */
    public function getMyInfo($userId)
    {
        $myInfo = $this->_model->with('followers', 'following', 'my_video')
            ->where('id', $userId)->first();
        $myInfo->total_followers = count($myInfo->followers);
        $myInfo->total_following = count($myInfo->following);
        $myInfo->total_video = count($myInfo->my_video);
        return $myInfo;
    }
}