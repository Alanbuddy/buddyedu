<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request, $schedule)
    {
        $schedule = Schedule::where('id', $schedule)
            ->with('course', 'course.teachers')
            ->with('point')
            ->first();
        return view('mobile.course-show', compact('schedule'));
    }

    public function home(Request $request)
    {
        $items = auth()->user()->enrolledShedules()
            ->with('point','course')
            ->paginate();
        dd($items);
    }
}
