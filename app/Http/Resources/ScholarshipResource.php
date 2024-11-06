<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScholarshipResource extends JsonResource
{
    private $funding_types=[
        "full"=>"تمويل كامل",
        "partial"=>"تمويل جزئي",
        "private"=>"نفقة خاصه"
    ];
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "title_en"=>$this->title_en,
            "title_ar"=> $this->title_ar,
            "description_en"=>$this->description_en,
            "description_ar"=>$this->description_ar,
            "country"=>$this->country->name_ar,
            "countryId"=>$this->country->_id,
            "funding_type"=>$this->funding_types[$this->funding_type],
            "funding_type_id"=>$this->funding_type,
            "content_en"=>$this->content_en,
            "content_ar"=>$this->content_ar,
            "image"=>asset(path: 'storage/'. $this->image),
            "visits"=>$this->formatVisits(),
            "user_id"=>$this->user_id,
            "deadline"=> $this->deadline,
            "created_at"=>$this->created_at->format('Y-M-d'),
            "degreeLevels"=>$this->degree_levels()->pluck('name_ar'),
            "degreeLevelsIds"=>$this->degree_levels()->pluck('degree_level_id'),
            "specializations"=>$this->specializations()->pluck('name_ar'),
            "specializationsIds"=>$this->specializations()->pluck('specialization_id'),
        ];
    }
}
