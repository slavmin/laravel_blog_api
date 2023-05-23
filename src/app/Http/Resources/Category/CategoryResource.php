<?php

namespace App\Http\Resources\Category;

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
 * @property string $content
 * @property array $options
 * @property string $image
 */
class CategoryResource extends JsonResource
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
            'content' => $this->content,
            // 'options' => $this->options,
            'image' => $this->image,
            // 'created' => new DateResource($this),
            // 'author' => new AuthorResource($this->whenLoaded('authorRelation')),
            'children' => self::collection($this->whenLoaded('childrenCategories')),
        ];
    }
}
