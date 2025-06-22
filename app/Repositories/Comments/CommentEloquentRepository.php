<?php

namespace App\Repositories\Comments;

use App\Models\Comment;
use App\Repositories\Eloquent\EloquentRepository;

class CommentEloquentRepository extends EloquentRepository implements CommentRepositoryInterface
{
    /**
     * Implement abstract method and base model
     *
     * @return mixed | model
     */
    public function getModel()
    {
        return Comment::class;
    }

    // Deploy special methods.
}