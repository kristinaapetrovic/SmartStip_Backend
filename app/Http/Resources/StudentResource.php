<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'year_of_study' => $this->year_of_study,
            'type_of_study' => $this->type_of_study,
            'average_grade' => $this->average_grade,
            'field_of_study' => $this->field_of_study,
            'index_number' => $this->index_number,
            'street_address' => $this->street_address,
            'phone_number' => $this->phone_number,
            'user' => new UserResource($this->whenLoaded('user')),
            'location' => new LocationResource($this->whenLoaded('location')),
            'faculty' => new FacultyResource($this->whenLoaded('faculty')),
        ];
    }
}
