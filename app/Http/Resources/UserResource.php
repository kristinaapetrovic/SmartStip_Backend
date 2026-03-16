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
        $role = null;

        if ($this->resource->isAdministrator()) {
            $role = 'administrator';
        } elseif ($this->resource->isStudent()) {
            $role = 'student';
        } elseif ($this->resource->isCommissioner()) {
            $role = 'commissioner';
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $role,
        ];
    }
}
