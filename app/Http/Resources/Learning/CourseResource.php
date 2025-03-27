<?php

namespace App\Http\Resources\Learning;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'about' => $this->about,
            'tags' => $this->tags,
            'thumbnail' => $this->thumbnail,
            'learningGoals' => $this->learning_goals,
            'requirements' => $this->requirements,
            'description' => $this->description,
            'startDate' => $this->start_date,
            'price' => $this->price,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'modules' => ModuleResource::collection($this->module),
        ];
    }
}
