<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'user_id' => $this->user_id,
            'caption' => $this->caption,
            'image' => $this->image ? asset("storage/uploads/images/{$this->image}") : null,
            'image_type' => $this->image ? $this->image_type : null,
            'media' => asset("storage/uploads/media/{$this->media}"),
            'media_type' => "video/$this->media_type",
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'profile_photo_url' => $this->user->profile_photo_url,
            ]
        ];
    }
}
