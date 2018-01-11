<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    use CourseEnrollTrait;

    function __construct()
    {
        $this->middleware('role:admin|operator')
            ->only(['create', 'store', 'destroy', 'update']);
        $this->middleware('role:admin|operator|merchant')
            ->only(['index', 'apply']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            if (!$this->isAdmin())
                $items = $this->getMerchant()->courses();
            else
                $items = Course::query();
            $items = $items->orderBy('id', 'desc')->get();
            return ['success' => true, 'data' => $items];
        }

        $items = Course::orderBy('id', 'desc')->withCount('merchants')->with('merchants');
        if ($request->key) {
            $items->where('name', 'like', '%' . $request->get('key') . '%');
        }

        $isAdmin = $this->isAdmin();
        if (!$isAdmin) {
            $merchant = auth()->user()->ownMerchant;
            if ($request->type == 'my') {
                $items = $merchant->courses();
                $count = Course::count();
            } else {
                $count = $merchant->courses()->count();
            }
        }

        $items = $items->paginate(10);
        if (!$isAdmin && $request->type != 'my') {
//            foreach ($items as $item) {
//                $item->added = $item->merchants->contains($merchant);//判断是否已添加课程
//            }
            $items->getCollection()->each->markHasAddedByMerchant($merchant);
//            array_map(function ($item) use ($merchant) {
//                $item->added = $item->merchants->contains($merchant);//判断是否已添加课程
//            }, $items->items());
        }

        if ($request->key) {
            $items->withPath(route('courses.index') . '?' . http_build_query(['key' => $request->key,]));
        }
        $key = $request->key;
        return view($isAdmin ? 'admin.auth-course.index' : ($request->type == 'my' ? 'agent.auth.self' : 'agent.auth.index'),
            compact('items', 'count', 'key'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules());
        $course = new Course();
        $course = $course->fill($request->only([
            'name', 'guide_price', 'proportion', 'icon', 'url', 'description', 'detail', 'lessons_count'
        ]));
        $course->status = 'draft';
        $course->save();
        return ['success' => true, 'data' => $course];
    }

    /**
     * course store and update validation rules
     * @return  array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'lessons_count' => 'required|numeric',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $isAdmin = $this->isAdmin();
        return view($isAdmin ? 'admin.auth-course.auth-info' : 'agent.auth.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $course = $course->fill($request->only([
            'name', 'price', 'discount'
        ]));
        $course->status = 'draft';
        $course->update();
        return ['success' => true, 'data' => $course];
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['success' => true]);
    }

    public function enrollIn(Course $course)
    {
        $user = auth()->user();
        $order = $this->getEnrollOrder($course);
        return $order
            ? $this->enroll($course, $user->id)
            : ['success' => false, 'message' => 'no finished order found'];
    }

    public function toggle(Course $course)
    {
        $course->update([
            'status' => $course->status == 'draft' ? 'publish' : 'draft'
        ]);
        return $course;
    }

    /**
     * 授权机构
     */
    public function merchants(Course $course)
    {
        $items = $course->merchants()
            ->withCount(['schedules as ongoingSchedulesCount' => function ($query) {
                $query->where('end', '>', date('Y-m-d H:i:s'));
            }])
            ->withCount(['schedules' => function ($query) {
                $query->where('end', '<', date('Y-m-d H:i:s'));
            }])
//            ->withCount('schedules')
            ->addSelect(DB::raw('(select count(*) from schedules join schedule_user on schedules.id=schedule_user.schedule_id where schedules.merchant_id=merchants.id and schedule_user.type=\'student\' and end > date_format(now(),\'%Y-%m-%d %H:%i:%s\')) as ongoingStudentsCount'))
            ->addSelect(DB::raw('(select count(*) from schedules join schedule_user on schedules.id=schedule_user.schedule_id where schedules.merchant_id=merchants.id and schedule_user.type=\'student\' and end < date_format(now(),\'%Y-%m-%d %H:%i:%s\')) as studentsCount'))
//            ->addSelect(DB::raw('(select count(*) from schedules join schedule_user where schedules.merchant_id=mid and schedule_user.type=\'student\') as studentsCount'))
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.auth-course.show', compact('items', 'course'));
    }

    public function comments(Request $request, Course $course)
    {
        if ($request->has('user_id'))
            return $this->commentsOfUser($course, $request->user_id);
        $items = $course->comments()
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate(10);
        return view('admin.auth-course.review', compact('items', 'course'));
    }

    public function commentsOfUser(Course $course, $userId)
    {
        $items = $course->comments()
            ->orderBy('id', 'desc')
            ->where('user_id', $userId)
            ->first();
        return ['success' => true, 'data' => $items];
    }

    public function apply(Course $course, Request $request)
    {
        $count = Application::courseType()
            ->where('object_id', $course->id)
            ->where('merchant_id', $this->getMerchant()->id)
            ->where('status', '<>', 'rejected')
            ->count();
        if ($count === 0) {
            $merchant = $this->getMerchant();
            $item = new Application(
                $request->only('remark')
            );
            $item->fill([
                'type' => 'course',
                'object_id' => $course->id,
                'merchant_id' => $merchant->id,
            ]);
            $item->save();
        }
        return ['success' => true];
    }
}
