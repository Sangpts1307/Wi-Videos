<?php

namespace App\Repositories\Videos;

interface VideoRepositoryInterface
{
    // Define method get video and live, follow using video id
    public function getVideo($videoId);
}