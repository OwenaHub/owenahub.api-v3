<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Learning\CourseCollection;
use App\Http\Resources\Learning\CourseResource;
use App\Models\Course;

class GetCoursesController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        return new CourseCollection($courses);
    }

    public function show(Course $course)
    {
        return new CourseResource($course);
    }
}
