<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExcuseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user?->name,
            'create_date' => $this->create_date,
            'stating' => $this->stating,
            'ending' => $this->ending,
            'state' => $this->state,
            'comments' => $this->comments,
            'user' => $this->user,
        ];
    }
}
