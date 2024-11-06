<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "title"=>$this->title,
            "url"=>$this->url,
            "isActivate"=>$this->isActivate,
            "mobile_image"=>asset(path: 'storage/'. $this->mobile_image),
            "desktop_image"=>asset(path: 'storage/'. $this->desktop_image),
            "startDate"=>\Carbon\Carbon::parse($this->start_date)->format('Y-m-d'),
            "endDate"=>\Carbon\Carbon::parse($this->end_date)->format('Y-m-d'),
        ];
    }
}
