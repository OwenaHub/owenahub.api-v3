<?php

namespace App\Http\Controllers\MentorProfile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\TaskRequest;
use App\Http\Resources\Mentor\TaskResource;
use App\Models\Lesson;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return TaskResource::collection($tasks);
    }

    public function store(TaskRequest $request, Lesson $lesson)
    {
        $data = $request->validated();

        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('task_images', 'public');
        }

        $task = $lesson->task()->create($data);
        return new TaskResource($task);
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $data = $request->validated();

        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('task_images', 'public');
        }

        $task->update($data);
        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
