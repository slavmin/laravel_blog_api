<?php

namespace App\Actions\Post;

use App\Models\Post;

final class PostForceDeleteAction
{
    public function __construct(private readonly Post $post)
    {
    }

    public function handle(): void
    {
        $this->post->removeTags();

        $this->post->removeCategories();

        $this->post->forceDelete();
    }
}
