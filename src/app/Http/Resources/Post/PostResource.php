<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use App\Http\Resources\DateResource;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\User\AuthorResource;
use App\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $content
 * @property array $content_blocks
 * @property string $hero_image
 * @property string $created_at
 */
class PostResource extends JsonResource
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
            'content_blocks' => $this->content_blocks,
            'image' => $this->hero_image,
            'created' => new DateResource($this),
            'author' => new AuthorResource($this->whenLoaded('authorRelation')),
            'tags' => TagResource::collection($this->whenLoaded('tagsRelation')),
            'categories' => CategoryResource::collection($this->whenLoaded('categoriesRelation')),
        ];
    }
}
