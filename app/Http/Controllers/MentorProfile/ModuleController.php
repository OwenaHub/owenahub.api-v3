<?php

namespace App\Http\Controllers\MentorProfile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\ModuleRequest;
use App\Models\Course;
use App\Models\Module;

class ModuleController extends Controller
{
    public function store(ModuleRequest $request, Course $course)
    {
        try {
            $data = $request->validated();

            if ($course->module()->where('position', $data['position'])->exists()) {
                return response()->json(['error' => 'A module with the same position already exists.'], 409);
            }

            $module = $course->module()->create($data);

            return response()->json($module, 201);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(ModuleRequest $request, Course $course, Module $module)
    {
        try {
            $data = $request->validated();

            if ($course->module()->where('position', $data['position'])->where('id', '!=', $module->id)->exists()) {
                return response()->json(['error' => 'A module with the same position already exists.'], 409);
            }

            $module->update($data);

            return response()->json($module, 200);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Course $course, Module $module)
    {
        try {
            if ($module->course_id !== $course->id) {
                return response()->json(['error' => 'Module does not belong to the specified course.'], 404);
            }

            return response()->json($module, 200);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Module $module)
    {
        try {
            $module->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
