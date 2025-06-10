<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Learning\TaskSubmissionResource;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\TaskSubmission;

class TaskSubmissionController extends Controller
{
    public function index()
    {
        $tasks = TaskSubmission::all();
        return TaskSubmissionResource::collection($tasks);
    }

    public function store(Request $request, Task $task)
    {
        $data = $request->validate([
            'task_id' => 'required|in:' . $task->id,
            'content' => 'nullable|string',
            'submission_image' => 'nullable|mimes:jpeg,png,jpg|image|max:2048',
            // 'status' => 'nullable|in:pending,failed,completed',
        ]);

        if ($request->hasFile('submission_image')) {
            $data['submission_image'] = $request->file('submission_image')->store('task_submission_images', 'public');
        }

        $submission = $request->user()->task_submission->create([
            'task_id' => $task->id,
            'content' => $data['content'],
            'file_url' => $data['submission_image'],
        ]);

        return new TaskSubmissionResource($submission);
    }

    public function show(TaskSubmission $taskSubmission)
    {
        return new TaskSubmissionResource($taskSubmission);
    }

    public function update(Request $request, TaskSubmission $taskSubmission)
    {
        $validatedData = $request->validate([
            'content' => 'nullable|string',
            'feedback' => 'nullable|string',
            'file_url' => 'nullable|url',
            // 'status' => 'nullable|in:pending,failed,completed',
        ]);

        $taskSubmission->update($validatedData);

        return new TaskSubmissionResource($taskSubmission);
    }

    public function destroy(TaskSubmission $taskSubmission)
    {
        $taskSubmission->delete();
        return response()->noContent();
    }
}
