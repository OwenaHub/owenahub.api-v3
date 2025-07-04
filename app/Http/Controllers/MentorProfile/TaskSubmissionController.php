<?php

namespace App\Http\Controllers\MentorProfile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mentor\TaskSubmissionResource;
use App\Models\Notification;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;

class TaskSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $mentor_profile = $request->user()->mentor_profile;
        $submissions = TaskSubmission::whereHas('task.lesson.module.course', function ($query) use ($mentor_profile) {
            $query->where('mentor_profile_id', $mentor_profile->id);
        })->latest()->get();

        return TaskSubmissionResource::collection($submissions);
    }

    public function show(TaskSubmission $taskSubmission)
    {
        return new TaskSubmissionResource($taskSubmission);
    }

    public function update(Request $request, TaskSubmission $taskSubmission)
    {
        $validatedData = $request->validate([
            'feedback' => ['nullable', 'string'],
            'status' => ['nullable', 'in:failed,completed,pending'],
        ]);

        $taskSubmission->update($validatedData);

        Notification::create([
            'user_id' => $taskSubmission->user_id,
            'source' => 'tasks',
            'content' => "You have received feedback for the task submission: {$taskSubmission->task->name}",
        ]);

        return new TaskSubmissionResource($taskSubmission);
    }
}
