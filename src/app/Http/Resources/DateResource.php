<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $created_at
 * @property string $updated_at
 */
class DateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request, string $fieldName = 'created_at'): array
    {
        // Localize Carbon
        Carbon::setlocale(config('app.locale'));

        return [
            'date' => Carbon::parse($this->$fieldName)->format('d.m.Y'),
            'time' => Carbon::parse($this->$fieldName)->format('H:i:s'),
            'datetime' => Carbon::parse($this->$fieldName)->format('Y-m-d H:i:s'),
            'humans' => Carbon::parse($this->$fieldName)->diffForHumans(),
        ];
    }
}
