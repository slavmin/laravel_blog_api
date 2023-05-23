<?php

namespace App\Http\Requests\Category;

use App\Models\User;
use App\Http\Requests\Request;
use Illuminate\Http\Concerns\InteractsWithInput;

class CategoryRequest extends Request
{
    use InteractsWithInput;

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'slug' => ['sometimes', 'nullable', 'string', 'max:100'],
            'content' => ['sometimes', 'nullable', 'string', 'max:7000'],
            'description' => ['sometimes', 'nullable', 'string', 'max:255'],
            'parent_id' => ['sometimes', 'nullable', 'uuid', 'exists:categories,uuid'],
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

    public function description(): ?string
    {
        return $this->get('description');
    }

    public function content(): ?string
    {
        return $this->get('content');
    }

    public function options(): array
    {
        return $this->get('options', []);
    }
}
