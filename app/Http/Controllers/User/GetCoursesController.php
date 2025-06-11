<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\CourseCollection;
use App\Http\Resources\User\CourseResource;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetCoursesController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        
        return new CourseCollection($courses);
    }

    public function show(Course $course, Request $request)
    {
        $is_enrolled = false;

        if (Auth::check()) {
            $is_enrolled = CourseEnrollment::where([
                ['user_id', $request->user()->id],
                ['course_id', $course->id]
            ])->exists();
        }

        return (new CourseResource($course))->additional(['isEnrolled' => $is_enrolled]);
    }
}
