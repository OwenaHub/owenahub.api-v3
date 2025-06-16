<?php

namespace App\Http\Controllers\MentorProfile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mentor\TaskSubmissionResource;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;

class TaskSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $mentor_profile = $request->user()->mentor_profile;
        $submissions = TaskSubmission::whereHas('task.lesson.module.course', function ($query) use ($mentor_profile) {
            $query->where('mentor_profile_id', $mentor_profile->id);
        })->get();

        return TaskSubmissionResource::collection($submissions);
    }

    public function update(Request $request, TaskSubmission $taskSubmission)
    {
        $validatedData = $request->validate([
            'feedback' => ['nullable', 'string'],
        ]);

        $taskSubmission->update($validatedData);

        return new TaskSubmissionResource($taskSubmission);
    }
}
