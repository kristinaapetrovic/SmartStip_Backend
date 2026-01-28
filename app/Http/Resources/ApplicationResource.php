<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'status'=>$this->status,
            'average_grade_url'=>$this->average_grade_url,
            'espb_url'=>$this->espb_url,
            'identification_card_url'=>$this->identification_card_url,
            'proof_of_unenrollment_url'=>$this->proof_of_unenrollment_url,
            'student'=>new StudentResource($this->whenLoaded('student')),
            'scholarship'=>new ScholarshipCallResource($this->whenLoaded('scholarship'))
        ];
    }
}
