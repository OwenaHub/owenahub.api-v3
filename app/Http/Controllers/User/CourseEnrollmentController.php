<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Learning\CourseCollection;
use App\Http\Resources\Learning\CourseResource;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseEnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $enrolled_courses = $user->course_enrollment()
            ->with('course')
            ->get()
            ->pluck('course')->filter();

        return new CourseCollection($enrolled_courses);
    }

    /**
     * Enroll a user in a course.
     */
    public function store(Request $request, Course $course)
    {
        $user = $request->user();

        if (CourseEnrollment::where([
            ['user_id', $user->id],
            ['course_id', $course->id],
        ])->exists()) {
            return response()->json([
                'error' => 'You\'ve already started this course!'
            ], 409);
        }

        try {
            DB::transaction(function () use ($user, $course, $request) {
                if ($course->price != 0.00) {
                    $response = RedeemVoucherCodeController::update($request, $course->price);

                    if ($response instanceof JsonResponse && $response->getStatusCode() !== 200) {
                        // throw new \Exception($response->getData(true)['error']);
                        return response()->json([
                            'error' => $response->getData(true)['error']
                        ], 400);
                    }
                }

                $user->course_enrollment()->create([
                    'course_id' => $course->id,
                    'user_id' => $user->id
                ]);

                $user->notification()->create([
                    'source' => 'courses',
                    'content' => `You have successfully enrolled in $course->title`
                ]);
            });

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, Course $course)
    {
        $user = $request->user();

        if (!$user->course_enrollment()->where('course_id', $course->id)->exists()) {
            return response()->json([
                'error' => 'You are not enrolled in this course.'
            ], 403);
        }

        return new CourseResource($course);
    }
}
