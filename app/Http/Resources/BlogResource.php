<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'id' => $this->id,
            "title" => $this->{"title_".$locale},
            'title_ar' => $this->title_ar,
            'title_en' => $this->title_en,
            'slug' => $this->{"slug_".$locale},
            "description" => $this->{"description_".$locale},
            'description_ar' => $this->description_ar,
            'description_en' => $this->description_en,
            'content_ar' => $this->content_ar,
            'content_en' => $this->content_en,
            'image' => asset(path: 'storage/'. $this->image),
            'author' => $this->user->name ?? $request->user('admin')->name ?? __("app.forsaty"),
            'created_at' => $this->created_at,
        ];
    }
}
