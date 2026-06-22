<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'vacancy' => new VacancyResource($this->whenLoaded('vacancy')),
            'created_at' => $this->created_at,
        ];
    }
}
