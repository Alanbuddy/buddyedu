<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Merchant;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ScheduleController extends Controller
{
    public function __construct()
    {
    }

    public function latest(Request $request)
    {
        $merchant = Merchant::findOrFail($request->get('merchant_id'));
        $now = Carbon::now();
        $items = $merchant->schedules()
            ->where('schedules.course_id', 1)
            ->where('schedules.begin', '>=', $now->toDateString())
            ->orderBy('id', 'desc')
            ->limit($request->get('size', 4))
            ->get();
        foreach ($items as $item) {
            $item->finished = $item->end > $now->toDateTimeString();
        }
        return $items;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('schedule.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'begin' => 'required',
            'end' => 'required',
        ]);
        $schedule = new Schedule();
        $schedule->fill($request->only([
            'begin',
            'end',
            'course_id',
            'merchant_id',
            'point_id',
        ]));

        $schedule->status = 'applying';
        $schedule->save();
        return ['success' => true];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        return view('schedule.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return ['success' => true];
    }

    /**
     * 课程授权
     */
    public function authorizeSchedule(Course $course, Schedule $schedule, $operation)
    {
        switch ($operation) {
            case 'apply':
                $course->schedules()->syncWithoutDetaching([$schedule->id => ['status' => 'applying']]);
                break;
            case 'authorize':
                $course->schedules()->syncWithoutDetaching([$schedule->id => ['status' => 'approved']]);
                break;
            case 'cancel':
                $course->schedules()->detach($course);
                break;
            default:
                return ['success' => false, 'message' => trans('error.unsupported')];
        }
        return ['success' => true];
    }
}
