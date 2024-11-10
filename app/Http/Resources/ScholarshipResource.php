<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScholarshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $locale=\Illuminate\Support\Facades\App::getLocale();
        return [
            "id"=> $this->id,
            "title_en"=>$this->title_en,
            "title" => $this->{"title_".$locale},
            "title_ar"=> $this->title_ar,
            'slug' => route("scholarship.details",[$this->{"slug_".$locale}]),
            "description_en"=>$this->description_en,
            "description_ar"=>$this->description_ar,
            "description" => $this->{"description_".$locale},
            "country"=>$this->country->{"name_".$locale},
            "countryId"=>$this->country->_id,
            "funding_type"=>__("app.".$this->funding_type),
            "funding_type_id"=>$this->funding_type,
            "content_en"=>$this->content_en,
            "content_ar"=>$this->content_ar,
            "content"=>$this->{"content_".$locale},
            "image"=>asset(path: 'storage/'. $this->image),
            "visits"=>$this->formatVisits(),
            "user_id"=>$this->user_id,
            "deadline"=> $this->deadline,
            "created_at"=>$this->created_at->format('Y-M-d'),
            "degreeLevels"=>$this->degree_levels()->pluck("name_".$locale),
            "degreeLevelsIds"=>$this->degree_levels()->pluck('degree_level_id'),
            "specializations"=>$this->specializations()->pluck("name_".$locale),
            "specializationsIds"=>$this->specializations()->pluck('specialization_id'),
        ];
    }
}
