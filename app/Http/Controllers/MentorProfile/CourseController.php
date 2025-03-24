<?php

namespace App\Http\Controllers\MentorProfile;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseRequest;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $mentor = $request->user()->mentor_profile;

        if (!$mentor) {
            return response()->json([
                'error' => 'User does not have a mentor profile'
            ], 404);
        }

        $courses = $mentor->course()->get();

        return response()->json([
            'courses' => $courses
        ]);
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

            return response([
                'course' => $course,
            ], 201);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(CourseRequest $request, Course $course)
    {
        $data = $request->validated();

        try {
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')->store('course_thumbnails', 'public');
            }

            $course->update($data);

            return response([
                'course' => $course,
            ], 201);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'course' => $course
        ]);
    }

    public function show(Course $course)
    {
        return response([
            'course' => $course->with('module')->get()
        ]);
    }

    public function delete(Course $course)
    {
        $course->delete();
        return response()->noContent();
    }
}
