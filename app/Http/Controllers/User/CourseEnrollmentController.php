<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\CourseCollection;
use App\Http\Resources\User\CourseResource;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\CoursePurchase;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            $response = null;

            DB::transaction(function () use ($user, $course, $request, &$response) {
                if ($course->price != 0.00) {

                    $use_subscription = $request->input('use_owenaplus');
                    $use_voucher = $request->input('code');
                    $use_one_time = $request->input('one_time');

                    // Log::info('Course Enrollment Request', [
                    //     'use_subscription' => $use_subscription,
                    //     'use_voucher' => $use_voucher,
                    //     'use_one_time' => $use_one_time,
                    // ]);

                    if (isset($use_voucher)) {
                        $voucherResponse = RedeemVoucherCodeController::update($request, $course->price);

                        if ($voucherResponse instanceof JsonResponse && $voucherResponse->getStatusCode() !== 200) {
                            throw new \Exception($voucherResponse->getData(true)['error']);
                        }

                        CoursePurchase::create([
                            'user_id' => $user->id,
                            'course_id' => $course->id,
                            'price' => $course->price
                        ]);

                        Payment::updateOrCreate(
                            [
                                'transaction_reference' => $use_voucher,
                                'user_id' => $user->id,
                            ],
                            [
                                'amount' => $course->price,
                                'purchase_item' => 'course',
                                'status' => 'successful',
                                'payment_gateway' => 'paystack',
                                'metadata' => json_encode([
                                    'payment_channel' => 'voucher code',
                                ]),
                            ]
                        );
                    } else if (isset($use_subscription)) {
                        $user->owenaplus_subscription = $user->owenaplus_subscription()->first();

                        if ($user->owenaplus_subscription && $user->owenaplus_subscription->status !== 'active') {
                            $response = response()->json([
                                'error' => 'Your OwenaPlus subscription is not active.'
                            ], 403);
                            return;
                        }

                        $user->course_enrollment()->create([
                            'course_id' => $course->id,
                            'user_id' => $user->id
                        ]);

                        $user->notification()->create([
                            'source' => 'courses',
                            'content' => "You enrolled in $course->title using your Subscription to OwenaPlus"
                        ]);

                        $response = response()->noContent();
                        return;
                    } else if (isset($use_one_time)) {
                        CoursePurchase::create([
                            'user_id' => $user->id,
                            'course_id' => $course->id,
                            'price' => $course->price
                        ]);

                        Payment::updateOrCreate(
                            [
                                'transaction_reference' => $use_one_time,
                                'user_id' => $user->id,
                            ],
                            [
                                'amount' => $course->price,
                                'purchase_item' => 'course',
                                'status' => 'successful',
                                'payment_gateway' => 'paystack',
                                'metadata' => json_encode([
                                    'payment_channel' => 'voucher code',
                                    'currency' => 'NGN',
                                ]),
                            ]
                        );
                    } else {
                        $response = response()->json([
                            'error' => 'Failed to enroll, contact support@owenahub.com'
                        ], 400);
                        return;
                    }
                }

                $user->course_enrollment()->create([
                    'course_id' => $course->id,
                    'user_id' => $user->id
                ]);

                $user->notification()->create([
                    'source' => 'courses',
                    'content' => "You have enrolled in $course->title"
                ]);
            });

            if ($response) return $response;
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

        // ---------------
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

        return new CourseResource($course);
    }
}
