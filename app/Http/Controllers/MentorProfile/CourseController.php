<?php

namespace App\Http\Controllers\MentorProfile;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseRequest;
use App\Http\Resources\Mentor\CourseCollection;
use App\Http\Resources\Mentor\CourseResource;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        try {
            $mentor = $request->user()->mentor_profile;

            if (!$mentor) {
                return response()->json([
                    'error' => 'User does not have a mentor profile'
                ], 404);
            }

            $courses = $mentor->course()->get();
            return new CourseCollection($courses);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function store(CourseRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')->store('course_thumbnails', 'public');
            }

            $course = $request->user()
                ->mentor_profile
                ->course()
                ->create($data);

            return new CourseResource($course);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Course $course)
    {
        $course->with('module');
        return new CourseResource($course);
    }

    public function update(CourseRequest $request, Course $course)
    {
        $data = $request->validated();

        try {
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')->store('course_thumbnails', 'public');
            }

            $course->update($data);
            return new CourseResource($course);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->noContent();
    }
}
