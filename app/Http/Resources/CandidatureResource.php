<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidatureResource extends JsonResource
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
            'cv' => $this->cv ? asset('storage/' . $this->cv) : null,
            'coverletter' => $this->coverletter ? asset('storage/' . $this->coverletter) : null,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'candidate' => $this->whenLoaded('candidate', function () {
                return [
                    'id' => $this->candidate->id,
                    'name' => $this->candidate->name,
                    'email' => $this->candidate->email,
                ];
            }),
            'annonce' => $this->whenLoaded('annonce', function () {
                return [
                    'id' => $this->annonce->id,
                    'title' => $this->annonce->title,
                    'description' => $this->annonce->description,
                    'created_at' => $this->annonce->created_at->toDateTimeString(),
                ];
            }),
        ];
    }
}
