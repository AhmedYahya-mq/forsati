<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            "user_id"=>$this->user_id,
            "scholarship_id"=>$this->scholarship_id ?? null,
            "parent_id"=> $this->parent_id ?? null,
            "blog_id" => $this->blog_id?? null,
            "content" => $this->content,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "user" => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'image' => asset("storage/".$this->user->image),
            ],
            "replies"=> CommentResource::collection($this->replies),
        ];
    }
}
