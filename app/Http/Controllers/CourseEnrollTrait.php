<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-7-10
 * Time: 上午10:50
 */

namespace App\Http\Controllers;


use App\Models\Course;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;

trait CourseEnrollTrait
{
    //学生加入课程
    public function enroll(Schedule $schedule, $user_id = 0)
    {
        $user = auth()->user() ?: User::findOrFail($user_id);
        $success = true;
        $count = $this->hasEnrolled($schedule, $user->id);
        if ($count == 0) {
            $schedule->users()->attach($user, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        $changed = $schedule->users()->syncWithoutDetaching($user);
        return ['success' => $success, 'changed' => $changed];
    }

    public function hasEnrolled($schedule)
    {
        return $schedule->users()
            ->count();
    }

    public function getEnrollOrder($course)
    {
        $user = auth()->user();
        return $user->orders()
            ->where('product_id', $course->id)
            ->where('status', 'paid')
            ->orderBy('id', 'desc')
            ->first();
    }

    public function isFull($schedule)
    {
        return ($schedule->quota
            && $schedule->students()->count() == $schedule->quota)
            ? true
            : false;
    }
}