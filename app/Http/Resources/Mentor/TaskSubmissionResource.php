<?php

namespace App\Http\Resources\Mentor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskSubmissionResource extends JsonResource
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
            'userId' => $this->user_id,
            'taskId' => $this->task_id,
            'content' => $this->content,
            'feedback' => $this->feedback,
            'fileUrl' => $this->file_url,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'user' => ['name' => $this->user->name],

            'task' => [
                'id' => $this->task->id,
                'name' => $this->task->name
            ],
            'course' => [
                'id' => $this->task->lesson->module->course->id,
                'title' => $this->task->lesson->module->course->title,
            ],
            'module' => [
                'id' => $this->task->lesson->module->id,
                'title' => $this->task->lesson->module->title,
                'position' => $this->task->lesson->module->position,
            ],
            'lesson' => [
                'id' => $this->task->lesson->id,
                'title' => $this->task->lesson->title,
                'position' => $this->task->lesson->position,
            ],
        ];
    }
}
