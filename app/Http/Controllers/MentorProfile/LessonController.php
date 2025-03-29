<?php

namespace App\Http\Controllers\MentorProfile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\LessonRequest;
use App\Http\Resources\Learning\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;

class LessonController extends Controller
{
    public function store(LessonRequest $request, Course $course, Module $module)
    {
        try {
            if ($module->course_id !== $course->id) {
                return response()->json(['error' => 'Module does not belong to the specified course.'], 404);
            }

            $data = $request->validated();

            if ($module->lesson()->where('position', $data['position'])->exists()) {
                return response()->json(['error' => 'A lesson with the same position already exists in this module.'], 409);
            }

            $lesson = $module->lesson()->create($data);
            return new LessonResource($lesson);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(LessonRequest $request, Course $course, Lesson $lesson)
    {
        try {
            if ($lesson->module->course_id !== $course->id) {
                return response()->json(['error' => 'Lesson does not belong to the specified course.'], 404);
            }

            $data = $request->validated();

            if ($lesson->module->lesson()
                ->where('position', $data['position'])
                ->where('id', '!=', $lesson->id)
                ->exists()
            ) {
                return response()->json(['error' => 'A lesson with the same position already exists in this module.'], 409);
            }

            $lesson->update($data);
            return new LessonResource($lesson);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Course $course, Module $module, Lesson $lesson)
    {
        try {
            if ($module->course_id !== $course->id) {
                return response()->json(['error' => 'Module does not belong to the specified course.'], 404);
            }

            if ($lesson->module_id !== $module->id) {
                return response()->json(['error' => 'Lesson does not belong to the specified module.'], 404);
            }

            return new LessonResource($lesson);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        try {
            if ($lesson->module->course_id !== $course->id) {
                return response()->json(['error' => 'Lesson does not belong to the specified course.'], 404);
            }

            $lesson->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
