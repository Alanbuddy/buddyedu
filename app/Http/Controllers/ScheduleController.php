<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Merchant;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    use CourseEnrollTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|merchant|operator'])->only(['create', 'index', 'store', 'storeStudent']);
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
            ->with('course')
            ->orderBy('id', 'desc')
            ->get();

        foreach ($items as $item) {
            $item->finished = $item->end < $now->toDateTimeString();
            $item->lessons_count = $item->course->lessons_count;
        }
        return $items;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function finishedSchedules()
    {
        return Schedule::where('schedules.end', '<', date('Y-m-d H:i:s'));
    }

    public function onGoingSchedules()
    {
        return Schedule::where('schedules.end', '>', date('Y-m-d H:i:s'));
    }

    public function index(Request $request)
    {
        $isAdmin = $this->isAdmin();
        $finished = $request->get('type') == 'finished';
        $key = $request->get('key');
        if ($isAdmin) {
            $items = Schedule::where('schedules.end', $finished ? '<' : '>', date('Y-m-d H:i:s'))
                ->with(['course', 'point', 'merchant', 'teachers'])
                ->withCount('students');
            if ($finished)
                $onGoingSchedulesCount = $this->onGoingSchedules()->count();
            else
                $finishedSchedulesCount = $this->finishedSchedules()->count();
        } else {
            $merchant = auth()->user()->ownMerchant;
            $items = $finished
                ? $this->finishedSchedules()->where('merchant_id', $merchant->id)
                : $merchant->schedules();
            $items->withCount('students')
                ->with(['course', 'point', 'merchant', 'teachers']);
            $onGoingSchedulesCount = $this->onGoingSchedules()->where('merchant_id', $merchant->id)->count();
            $finishedSchedulesCount = $this->finishedSchedules()->where('merchant_id', $merchant->id)->count();
        }
        if ($key) {
            $items->join('courses', 'courses.id', '=', 'schedules.course_id')
                ->where('courses.name', 'like', "%$key%");
        }
        $items = $items->orderByDesc('id')->paginate(10);
        if ($key)
            $items->withPath(route('schedules.index') . '?' . http_build_query(['key' => $key,]));
        return view($isAdmin ? ($finished ? 'admin.course.history-course' : 'admin.course.course-list') : ($finished ? 'agent.course.history-course' : 'agent.course.index'),
            compact('items', 'key', 'onGoingSchedulesCount', 'finishedSchedulesCount', 'merchant'));
    }

//    /**
//     * 历史开课
//     * /schedules?type=finished
//    public function finished()
//    {
//        $items = Schedule::where('end', '<', Carbon::now()->toDateTimeString())
//            ->paginate(10);
//        return view('admin.course.histroy-course', compact('items'));
//    }
//
//    public function search(Request $request)
//    {
//        $key = $request->get('key');
//        $isHistory = $request->get('type');
//        $items = [];
//        return view('admin.course.course-search', compact('items', 'key'));
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'course_id' => 'required|numeric',
            'point_id' => 'required|numeric',
            'begin' => 'required|date',
            'end' => 'required|date',
            'teachers' => 'required|array',
            'lessons_count' => 'required|numeric',
        ]);
        $merchant = $this->getMerchant();
        $isBatch = $this->isBatch($merchant, $request->course_id);
        if (!$isBatch)
            $this->validate($request, [
                'quota' => 'required|numeric',
                'price' => 'required|numeric',
                'time' => 'max:200'
            ]);

        //检查机构是否已经取得课程授权
        $courseHasBeenAuthorized = $this->getMerchant()->courses()->where('id', $request->course_id)->count();
        if (!$courseHasBeenAuthorized) {
            abort(500, 'course has not authorized');
        }

        $arr = [];
        foreach ($request->teachers as $k => $v) {
            $arr[$v] = [
                'type' => 'teacher',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        $application = new Application(
            $request->only('remark')
        );
        DB::transaction(function () use ($arr, $application, $request) {
            $schedule = new Schedule();
            $schedule->fill($request->only([
                'begin',
                'end',
                'time',
                'course_id',
                'point_id',
                'price',
                'lessons_count',
                'quota'
            ]));

            $schedule->status = 'applying';
            $schedule->merchant_id = auth()->user()->ownMerchant->id;
            $schedule->save();
            //save teachers
            $schedule->teachers()->sync($arr);

            //save application
            $application->fill([
                'type' => 'schedule',
                'status' => 'applying',
                'merchant_id' => $this->getMerchant()->id
            ]);
            $schedule->applications()->save($application);
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
        $progress = $schedule->attendances()->max('ordinal_no');
        $isAdmin = $this->isAdmin();
        $schedule->course = $schedule->merchant->courses()->where('id', $schedule->course_id)->first();
        $schedule->is_batch = $schedule->course->pivot->is_batch;
        $teachers = $schedule->merchant->teachers;
        foreach ($schedule->teachers as $t) {
            if ($teachers->contains($t))
                $teachers->find($t)->selected = true;
        }
        $old = Schedule::where('parent', $schedule->id)->orderByDesc('id')->first();
        return view(($isAdmin ? 'admin' : 'agent') . '.course.course-info', compact('schedule', 'progress', 'teachers', 'old'));
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
        if ($request->has('hidden'))
            return $this->toggleHidden($request, $schedule);

        $application = new Application(
            $request->only('remark')
        );

        $arr = [];
        foreach ($request->teachers as $k => $v) {
            $arr[$v] = [
                'type' => 'teacher',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        $revisionArr = [];
        foreach ($schedule->teachers as $item) {
            $revisionArr [$item->id] = [
                'type' => 'teacher',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::transaction(function () use ($revisionArr, $arr, $schedule, $application, $request) {
            $properties = $schedule->getAttributes();
            array_splice($properties, 0, 1);
            $revisionSchedule = Schedule::create(array_merge($properties, ['parent' => $schedule->id]));

            $schedule->update(array_merge(
                ['status' => 'applying'],
                $request->only(['begin', 'end', 'time', 'course_id', 'point_id', 'price', 'lessons_count', 'quota']
                )));

            //save teachers
            $revisionSchedule->teachers()->sync($revisionArr);
            $schedule->teachers()->sync($arr);

            //save application
            $application->fill([
                'type' => 'schedule',
                'status' => 'applying',
                'merchant_id' => $this->getMerchant()->id
            ]);
            $schedule->applications()->save($application);
        });

        return ['success' => true];

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
        return ['success' => true, 'data' => $items];
    }

    public function enrolls(Request $request, Schedule $schedule)
    {
        $items = $schedule->students();
        $isAdmin = $this->isAdmin();
        if (!$isAdmin) {
            $isBatch = $this->isBatch($this->getMerchant(), $schedule->course_id);
        }

        if ($key = $request->key) {
            $items->where(function ($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%')->orWhere('phone', 'like', '%' . $key . '%');
            });
        }
        $items = $items->paginate(10);
        if ($key)
            $items->withPath(route('schedule.student', $schedule) . '?' . http_build_query(['key' => $key,]));
        return view($isAdmin ? 'admin.course.course-register' : 'agent.course.register', compact('items', 'schedule', 'isBatch', 'key'));
    }

    //报名成功
    public function enrolled(Schedule $schedule)
    {
//        return redirect(route('landing', $schedule));
        return view('mobile.register-success', compact('schedule'));
//        $user = auth()->user();
//        $order = $this->getEnrollOrder($schedule);
//        return $order ? $this->enroll($schedule, $user->id) : ['success' => false, 'message' => 'no finished order found'];
    }

    // /api/v1/schedules/sign-in?schedule_id=1&api_token=da262427-88c6-356a-a431-8686856c81b3&ordinal_no=1&merchant_id=1&point_id=1&students[]=1&students[]=2
    public function signIn(Request $request)
    {
        $this->validate($request, [
            'merchant_id' => 'required',
            'point_id' => 'required',
            'schedule_id' => 'required',
            'students' => 'sometimes | array'
        ]);
        $arr = $request->get('students', []);
        Log::debug('students: ' . json_encode($arr));
        $items = User::whereIn('id', $arr)->get();

        $attendances = Schedule::findOrFail($request->schedule_id)
            ->attendances()->where('ordinal_no', $request->ordinal_no)
            ->delete();
//        dd($attendances->whereNotIn('student_id',$request->students));
//        dd($attendances);
        foreach ($items as $item) {
            $attendance = new Attendance();
            $attendance->fill(array_merge($request->only([
                'merchant_id',
                'point_id',
                'schedule_id',
                'ordinal_no',
            ]), [
                'teacher_id' => auth()->user()->id,
            ]));
            $item->attendances()->save($attendance);
        }
        return ['success' => true];
    }

    //url:   /api/v1/schedules/attendances?schedule_id=1&api_token=da262427-88c6-356a-a431-8686856c81b3
    //ordinal_no is 1 based index
    public function attendances(Request $request)
    {
        $schedule = Schedule::findOrFail($request->schedule_id);
        if ($request->has('ordinal_no')) {
            $items = $schedule->students()
                ->withCount(['attendances' => function ($query) use ($request) {
                    $query->where('ordinal_no', $request->ordinal_no)
                        ->where('schedule_id', $request->schedule_id);
                }])
                ->get();
        } else {
//            $course = $schedule->course;
            $items = $schedule->attendances()
                ->select(DB::raw('count("id") as count'))
                ->addSelect('ordinal_no')
                ->groupBy('ordinal_no')
                ->get();
            $arr = [];
            foreach ($items as $item) {
                $arr[] = $item->ordinal_no;
            }
            $arr2 = range(1, $schedule->lessons_count);
            $diff = collect($arr2)->diff(collect($arr))->values();
            foreach ($diff as $item) {
                $items->push(new Attendance(['count' => 0, 'ordinal_no' => $item]));
            }
        }
        return ['success' => true, 'data' => $items];
    }

    public function approve(Schedule $schedule, $operation)
    {
        $status = $operation == 'approve' ? 'approved' : 'rejected';
        $schedule->update(['status' => $status]);
        return ['success' => true];
    }

    public function comments(Request $request, Schedule $schedule)
    {
        $items = $schedule->comments()
            ->with('user')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return $request->ajax() ? ['success' => true, compact('items')] : view('mobile.student-course-review', compact('items'));
    }

    public function batchEnroll(Request $request, Schedule $schedule)
    {
        $this->validate($request, ['students' => 'required|array']);
        $ids = $request->get('students', []);
        $merchant = $schedule->merchant;
        $quantity = $this->getQuantity($merchant, $schedule->course_id);
        $exist = $merchant->courses()->wherePivot('is_batch', true)
            ->where('courses.id', $schedule->course_id)
            ->join('schedules', 'schedules.course_id', '=', 'courses.id')
            ->join('schedule_user', 'schedule_user.schedule_id', '=', 'schedules.id')
            ->groupBy('user_id')
            ->count();
        $remain = $quantity > $exist ? $quantity - $exist : 0;
        if (!$remain || $remain < count($ids))
            return ['success' => false, 'data' => compact('exist', 'remain'), 'message' => "not enough accounts,only $remain left,$exist accounts has been assigned"];
        DB::transaction(function () use ($ids, $schedule) {
            $arr = [];
            array_walk($ids, function ($v) use (&$arr) {
                $arr[$v] = ['type' => 'student'];
            });
            Log::debug(json_encode($arr));
            $changed = $schedule->students()->syncWithoutDetaching($arr);
            Log::debug(json_encode($changed));
            $this->getMerchant()->users()->syncWithoutDetaching($ids);
        });
        return ['success' => true];
    }

    /**
     * @param Request $request
     * @param Schedule $schedule
     * @return array
     */
    public function toggleHidden(Request $request, Schedule $schedule)
    {
        $schedule->update(['hidden' => $request->hidden]);
        return ['success' => true];
    }

}
