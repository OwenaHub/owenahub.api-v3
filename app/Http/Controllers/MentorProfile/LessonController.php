<?php

namespace App\Http\Controllers\MentorProfile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\LessonRequest;
use App\Http\Resources\Learning\LessonResource;
use App\Models\Lesson;
use App\Models\Module;

class LessonController extends Controller
{
    public function store(LessonRequest $request, Module $module, Lesson $lesson)
    {
        try {
            $data = $request->validated();

            if ($lesson->where('position', $data['position'])->exists()) {
                return response()->json(['error' => 'A lesson with the same position already exists.'], 409);
            }

            $new_lesson = $module->lesson()->create($data);
            return new LessonResource($new_lesson);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(LessonRequest $request, Lesson $lesson)
    {
        try {
            $data = $request->validated();

            if ($lesson->where('position', $data['position'])->exists()) {
                return response()->json(['error' => 'A lesson with the same position already exists.'], 409);
            }

            $lesson->update($data);
            return new LessonResource($lesson);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Module $module, Lesson $lesson)
    {
        try {
            if ($lesson->module_id !== $module->id) {
                return response()->json(['error' => 'Lesson does not belong to the specified course module.'], 404);
            }
            return new LessonResource($lesson);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Lesson $lesson)
    {
        try {
            $lesson->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
