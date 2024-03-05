<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'emp_no' => (int)$this->employee_no,
            'name' => $this->name,
            'email' => $this->email,
            'is_active' => (bool)$this->is_active,
            'vacation_days' => (string)$this->vacation_days, 
            'join_date' => $this->join_date,
            'role' => $this->role,
            'department_id' => $this->department?->id,
            'department_value' => $this->department?->title,
            'job_titles_id' => $this->job_titles_id,
            'job_titles_value'=> $this->job_title?->title, 
            'vacation' => $this->vacation,
            'Excuse' => $this->Excuse,
        ];
    }
}
