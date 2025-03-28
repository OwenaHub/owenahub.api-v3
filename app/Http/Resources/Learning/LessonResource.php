<?php

namespace App\Http\Resources\Learning;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'moduleId' => $this->module_id,
            'title' => $this->title,
            'position' => $this->position,
            'content' => $this->content,
            'videoUrl' => $this->video_url,
        ];
    }
}
