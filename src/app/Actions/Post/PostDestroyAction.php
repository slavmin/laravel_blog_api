<?php

namespace App\Actions\Post;

use App\Models\Post;

final class PostDestroyAction
{
    public function __construct(private readonly Post $post)
    {
    }

    public function handle(): void
    {
        $this->post->delete();
    }
}
