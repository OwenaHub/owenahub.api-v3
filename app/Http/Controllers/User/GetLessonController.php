<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetLessonController extends Controller
{
    public function index(Request $request, Course $course, Module $module, Lesson $lesson)
    {
        $user = $request->user();

        try {
            // Check if user is enrolled in this course
            if (
                !$request->user()
                    ->course_enrollment()
                    ->where('course_id', $course->id)->exists()
            ) {
                return response()->json([
                    'error' => 'You are not enrolled in this course.'
                ], 403);
            }

            // If user subscription is donex
            if ($course->price != 0.00) {
                $course->load(['course_purchase' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                }]);

                if ($course->course_purchase->isEmpty() && (!isset($user->owenaplus_subscription) || $user->owenaplus_subscription->status !== 'active')) {
                    return response()->json([
                        'error' => 'Renew your subscription to access this course'
                    ], 403);
                }
            }

            // So the user doen't try to fetch random modules from other lessons
            if ($module->course_id !== $course->id || $lesson->module_id !== $module->id) {
                return response()->json([
                    'error' => 'Lesson does not belong to the specified course.'
                ], 404);
            }

            // Marking the lesson as completed or not
            $lesson->completed = $lesson->user_lesson()->where('user_id', Auth::id())->exists();

            return new LessonResource($lesson);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'completed' => 'required|boolean',
        ]);

        try {
            $courseEnrollment = $request->user()->course_enrollment()
                ->where('course_id', $lesson->module->course_id)
                ->first();

            if (!$courseEnrollment) {
                return response()->json([
                    'error' => 'You are not enrolled in this course.'
                ], 403);
            }

            $request->user()->user_lesson()->updateOrCreate([
                'lesson_id' => $lesson->id,
                'course_enrollment_id' => $courseEnrollment->id,
                'completed' => $data['completed'],
            ]);

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
