<?php

namespace App\Http\Requests\Tag;

use App\Models\User;
use App\Http\Requests\Request;
use Illuminate\Http\Concerns\InteractsWithInput;
use Illuminate\Validation\Rule;

class TagRequest extends Request
{
    use InteractsWithInput;

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100', Rule::unique((new \App\Models\Tag())->getTable(), 'title')->ignore($this->tag?->id)],
            'slug' => ['sometimes', 'nullable', 'string', 'max:100'],
            'description' => ['sometimes', 'nullable', 'string', 'max:255'],
            'featured' => ['sometimes', 'nullable', 'boolean'],
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
}
