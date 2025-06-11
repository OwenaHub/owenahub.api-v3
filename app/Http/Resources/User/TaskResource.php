<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
            'submission' => TaskSubmissionResource::collection(
                $this->task_submission()
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get()
            ),
        ];
    }
}
