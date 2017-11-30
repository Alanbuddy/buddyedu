<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Merchant;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|merchant'])->only([
            'index',
            'store'
        ]);
    }

    //教师选班级
    //test url: /api/v1/schedules?merchant_id=1&api_token=da262427-88c6-356a-a431-8686856c81b3
    public function latest(Request $request)
    {
        $this->validate($request, [
            'merchant_id' => 'required'
        ]);
        $teacher = auth()->user();
        $now = Carbon::now();
        $items = $teacher
            ->schedules()
            ->where('schedules.merchant_id', $teacher->merchant_id)
//            ->where('schedules.end', '>', $now->toDateString())
            ->with('point')
            ->orderBy('id', 'desc')
            ->get();
        foreach ($items as $item) {
            $item->finished = $item->end < $now->toDateTimeString();
        }
        return $items;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->get('type') == 'finished') {
            return $this->finished($request);
        }
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            $items = Schedule::where('schedules.end', '>', Carbon::now()->toDateString())
                ->with(['course', 'point', 'merchant', 'teachers'])
                ->withCount('students')
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else {
            $items = $user->merchant()->schedules()
                ->paginate(10);
        }
        return view('admin.course.course-list', compact('items'));
    }

    /**
     * 历史开课
     * /schedules?type=finished
     */
    public function finished()
    {
        $items = Schedule::where('end', '<', Carbon::now()->toDateTimeString())
            ->paginate(10);
        return view('admin.course.histroy-course', compact('items'));
    }

    public function search(Request $request)
    {
        $items = [];
        return view('admin.course.course-search', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agent.course.index');
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
            'course_id' => 'required',
            'point_id' => 'required',
            'begin' => 'required|date',
            'end' => 'required|date',
            'teachers' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {

            $schedule = new Schedule();
            $schedule->fill($request->only([
                'begin',
                'end',
                'course_id',
                'merchant_id',
                'point_id',
                'quota'
            ]));

            $schedule->status = 'applying';
            $schedule->merchant_id = auth()->user()->ownMerchant->id;
            $schedule->save();
            $arr = [];
            foreach ($request->teachers as $k => $v) {
                $arr[$v] = [
                    'type' => 'teacher',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            $schedule->teachers()->sync($arr);
        });
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
        $item = $schedule;
        return view('admin.course.course-info', compact('item'));
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


    // /api/v1/schedules/students?schedule_id=1&api_token=da262427-88c6-356a-a431-8686856c81b3
    public function students(Request $request, Schedule $schedule)
    {
        $this->validate($request, [
            'schedule_id' => 'required|numeric'
        ]);
        $schedule = Schedule::findOrFail($request->get('schedule_id'));
        $items = $schedule->students()->get();
//        return $items;
        return ['success' => true, 'data' => $items];
    }

    public function signIn(Request $request)
    {
        $this->validate($request, [
            'merchant_id' => 'required',
            'point_id' => 'required',
            'schedule_id' => 'required'
        ]);
        $arr = $request->get('students');
        Log::debug(json_encode($arr));
        $items = User::whereIn('id', $arr)
            ->get();
        foreach ($items as $item) {
            $attendance = new Attendance();
            $attendance->fill(array_merge($request->only([
                'merchant_id',
                'point_id',
                'schedule_id',
            ]), [
                'teacher_id' => auth()->user()->id,
            ]));
            $item->attendances()->save($attendance);
        }
        return ['success' => true];
    }
}
