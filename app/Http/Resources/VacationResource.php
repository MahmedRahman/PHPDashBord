<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VacationResource extends JsonResource
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
            'create_date' => $this->create_date,
            'starting' => $this->stating, // Note: There might be a typo in your model's fillable attribute 'stating'. If it's supposed to be 'starting', adjust accordingly.
            'ending' => $this->ending,
            'days' => $this->days,
            'type' => $this->type,
            'state' => $this->state,
            'comments' => $this->comments,
            //'user_id' => $this->user_id,
            'user' => $this->user , // Assuming you have a UserResource
        ];
    }
}
