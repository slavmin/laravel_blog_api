<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use App\Http\Resources\DateResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $uuid
 * @property string $name
 */
class AuthorResource extends JsonResource
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
            // 'uuid' => $this->uuid,
            'name' => $this->name,
            // 'created' => new DateResource($this),
            // 'roles' => RoleResource::collection($this->whenLoaded('roles')),
        ];
    }
}
