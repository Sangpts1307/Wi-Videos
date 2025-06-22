<?php

namespace App\Repositories\Follows;

use App\Models\Follow;
use App\Repositories\Eloquent\EloquentRepository;

class FollowEloquentRepository extends EloquentRepository implements FollowRepositoryInterface
{
    /**
     * Implement abstract method and base model
     *
     * @return mixed | model
     */
    public function getModel()
    {
        return Follow::class;
    }

    // Deploy special methods.
}