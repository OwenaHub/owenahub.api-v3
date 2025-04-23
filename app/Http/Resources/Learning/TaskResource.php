<?php

namespace App\Http\Resources\Learning;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'lessonId' => $this->lesson_id,
            'imageUrl' => $this->image_url,
            'name' => $this->name,
            'instruction' => $this->instruction,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            // 'submissions' => TaskSubmissionResource::collection($this->whenLoaded('submissions')),
        ];
    }
}
