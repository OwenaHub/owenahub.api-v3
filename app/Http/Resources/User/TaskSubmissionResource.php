<?php

namespace App\Http\Resources\User;

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
            'task' => [
                'id' => $this->task->id,
                'name' => $this->task->name
            ],
            'taskId' => $this->task_id,
            'content' => $this->content,
            'feedback' => $this->feedback,
            'fileUrl' => $this->file_url,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'course' => [
                'id' => $this->task->lesson->module->course->id,
                'title' => $this->task->lesson->module->course->title,
            ],
            'module' => [
                'id' => $this->task->lesson->module->id,
                'title' => $this->task->lesson->module->title,
            ],
            'module' => [
                'id' => $this->task->lesson->module->id,
                'title' => $this->task->lesson->module->title,
            ],
        ];
    }
}
