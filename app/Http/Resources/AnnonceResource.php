<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnonceResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'company' => $this->company,
            'location' => $this->location,
            'salary_range' => $this->salary_range,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'recruiter' => $this->whenLoaded('recruiter', function(){
                return [
                    'name' => $this->recruiter->fname.' '.$this->recruiter->lname,
                    "email" => $this->email
                ];
            }),
            'candidatures' => $this->whenLoaded('candidatures', function(){
                return $this->candidatures->map(function($item){
                    return [
                        'cv' => $item->cv,
                        'coverletter' => $item->coverletter,
                        'status' => $item->status,
                        'candidate' => [
                            'fname' => $item->candidate->fname,
                            'lname' => $item->candidate->lname,
                            'email' => $item->candidate->email
                        ]
                    ];
                });
            })
        ];
    }
}
