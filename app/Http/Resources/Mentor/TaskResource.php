<?php

namespace App\Http\Resources\Mentor;

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
        ];
    }
}
