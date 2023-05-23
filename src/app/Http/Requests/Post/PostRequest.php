<?php

namespace App\Http\Requests\Post;

use App\Models\User;
use App\Http\Requests\Request;
use Illuminate\Http\Concerns\InteractsWithInput;

class PostRequest extends Request
{
    use InteractsWithInput;

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:100'],
            'description' => ['sometimes', 'nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:7000'],
            'content_blocks' => ['sometimes', 'nullable', 'string'],
            'original_author' => ['sometimes', 'nullable', 'string', 'max:255'],
            'original_link' => ['sometimes', 'nullable', 'string', 'max:255'],
            'tags' => ['array', 'nullable'],
            'tags.*' => ['exists:tags,uuid'],
            'categories' => ['array', 'nullable'],
            'categories.*' => ['exists:categories,uuid'],
            'featured' => ['sometimes', 'nullable', 'boolean'],
            'options' => ['array', 'nullable'],
        ];
    }

    public function author(): User
    {
        return $this->user();
    }

    public function title(): string
    {
        return $this->get('title');
    }

    public function content(): string
    {
        return $this->get('content');
    }

    public function contentBlocks(): ?string
    {
        return $this->get('content_blocks');
    }

    public function description(): ?string
    {
        return $this->get('description');
    }

    public function tags(): array
    {
        return $this->get('tags', []);
    }

    public function options(): array
    {
        return $this->get('options', []);
    }

    public function categories(): array
    {
        return $this->get('categories', []);
    }
}
