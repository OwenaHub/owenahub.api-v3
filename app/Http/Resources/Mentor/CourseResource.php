<?php

namespace App\Http\Resources\Mentor;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            $this->mergeWhen(Auth::check() && Auth::user()->mentor_profile, [
                'status' => $this->status
            ]),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'modules' => ModuleResource::collection($this->module->sortBy('position')),
            'creator' => new UserResource($this->mentor_profile->user)
        ];
    }
}
