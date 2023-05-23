<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Request;
use App\Http\Resources\DateResource;
use App\Http\Resources\User\AuthorResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property string $slug
 * @property string $description
 */
class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            'uuid' => $this->uuid,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            // 'created' => new DateResource($this),
            // 'author' => new AuthorResource($this->whenLoaded('authorRelation')),
        ];
    }
}
