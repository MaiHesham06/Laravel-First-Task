<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'type'             => $this->type,
            'value'            => $this->value,
            'price_adjustment' => $this->price_adjustment,
            'created_by'       => $this->creator?->name,
            'updated_by'       => $this->updater?->name,
            'created_at'       => $this->created_at,
        ];
    }
}
