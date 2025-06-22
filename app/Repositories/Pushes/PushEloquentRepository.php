<?php

namespace App\Repositories\Pushes;

use App\Models\Push;
use App\Repositories\Eloquent\EloquentRepository;

class PushEloquentRepository extends EloquentRepository implements PushRepositoryInterface
{
    /**
     * Implement abstract method and base model
     *
     * @return mixed | model
     */
    public function getModel()
    {
        return Push::class;
    }

    // Deploy special methods.
}