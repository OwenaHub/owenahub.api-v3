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

        // Ensure you're fetching courses through the correct relationship
        $enrolled_courses = $user->course_enrollment()->with('course')->get()->pluck('course');

        return new CourseCollection($enrolled_courses);
    }

    /**
     * Enroll a user in a slice.
     */
    public function store(Request $request, Course $course)
    {
        $user = $request->user();

        if (CourseEnrollment::where([
            ['user_id', $user->id],
            ['course_id', $course->id],
        ])->exists()) {
            return response()->json([
                'error' => 'You\'ve already started this slice!'
            ], 409);
        }

        try {
            DB::transaction(function () use ($user, $course, $request) {
                if ($course->price != 0.00) {
                    $response = RedeemVoucherCodeController::update($request, $course->price);

                    // Check if update() returned an error
                    if ($response instanceof JsonResponse && $response->getStatusCode() !== 200) {
                        throw new \Exception($response->getData(true)['error']);
                    }
                }

                $user->course_enrollment()->create([
                    'course_id' => $course->id,
                    'user_id' => $user->id
                ]);

                $user->notification()->create([
                    'topic' => 'New Enrollment',
                    'source' => 'courses',
                    'content' => "Congratulations! You have successfully enrolled in a new course."
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
