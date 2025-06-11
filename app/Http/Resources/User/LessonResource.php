<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();

        $completed = $user && $this->user_lesson()
            ->where('user_id', $user->id)
            ->exists() ?? false;

        return [
            'id' => $this->id,
            'moduleId' => $this->module_id,
            'title' => $this->title,
            'position' => $this->position,
            'content' => $this->content,
            'videoUrl' => $this->video_url,
            $this->mergeWhen(Auth::check(), [
                'completed' => $completed,
                'tasks' => TaskResource::collection($this->task),
            ]),
        ];
    }
}
