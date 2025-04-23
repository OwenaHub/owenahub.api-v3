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
            'user_id' => 'required|uuid|exists:users,id',
            'task_id' => 'required|in:'.$task->id,
            'content' => 'nullable|string',
            'file_url' => 'nullable|url',
            'status' => 'nullable|in:pending,failed,completed',
        ]);

        $submissions = TaskSubmission::create($data);
        return new TaskSubmissionResource($submissions);
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
            'status' => 'nullable|in:pending,failed,completed',
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
