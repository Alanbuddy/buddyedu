<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Course;
use App\Models\Merchant;
use App\Models\Point;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\File;
use Faker\Provider\Uuid;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use function Sodium\crypto_box_publickey_from_secretkey;

class MerchantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->only(['index']);
        $this->middleware('role:admin|merchant')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Merchant::orderBy('id', 'desc')
            ->withCount(['schedules as ongoingSchedules' => function ($query) {
                $query->where('end', '>', Carbon::now()->toDateTimeString());
            }])
            ->withCount(['schedules' => function ($query) {
                $query->where('end', '<=', Carbon::now()->toDateTimeString());
            }])
            ->with('admin');
        if ($request->key) {
            $items->where('name', 'like', '%' . $request->get('key') . '%');
        }
        $items = $items->paginate(10);
        if ($request->key) {
            $items->withPath(route('points.index') . '?' . http_build_query(['key' => $request->key,]));
        }
        return view('admin.org-manage.index', compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        Cache::put('a',3,10);
//        dd(Cache::get('a'));
        return view('merchant.create');
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

        ]);

        $data = $request->only([
            'name',
            'adminName',
            'phone',
            'password'
        ]);
        $item = new Merchant();
        DB::transaction(function () use ($item, $data) {
            $admin = new User();
            $admin->fill([
                'name' => $data['adminName'],
                'phone' => $data['phone'],
                'password' => bcrypt($data['password']),
                'status' => 'approved',
                'api_token' => Uuid::uuid(),
            ]);
            $admin->save();
            $admin->attachRole(Role::find(2));
            $item->fill([
                'name' => $data['name'],
                'admin_id' => $admin->id,
                'status' => 'authorized'
            ]);
//        $item->address = implode('', $request->only('province', 'city', 'county', 'street'));
            $item->save();
        });
        return ['success' => true, 'data' => $item];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merchant $merchant
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Merchant $merchant)
    {
        if ($finished = $request->type == 'finished') {
            $items = $merchant->finishedSchedules();
        } else {
            $items = $merchant->ongoingSchedules();
        }
        $items = $items->with('point')
            ->with('teachers')
            ->with('students')
            ->paginate(10);
        return view('admin.org-manage.show', compact('merchant', 'items', 'finished'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Merchant $merchant
     * @return \Illuminate\Http\Response
     */
    public function edit(Merchant $merchant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Merchant $merchant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merchant $merchant)
    {
        $data = $request->only([
            'name',
            'address',
        ]);
        $merchant->update($data);
        return ['success' => true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Merchant $merchant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merchant $merchant)
    {
        $merchant->delete();
        return ['success' => true];
    }

    public function toggle(Merchant $merchant)
    {
        $merchant->update([
            'status' => $merchant->status == 'authorized' ? 'unauthorized' : 'authorized'
        ]);
        return $merchant;
    }

    /**
     * 课程授权
     */
    public function authorizeCourse(Merchant $merchant, Course $course, $operation)
    {
        switch ($operation) {
            case 'apply':
                $merchant->courses()->syncWithoutDetaching([$course->id => ['status' => 'applying']]);
                break;
            case 'approve':
                $merchant->courses()->syncWithoutDetaching([$course->id => ['status' => 'approved']]);
                break;
            case 'reject':
                $merchant->courses()->syncWithoutDetaching([$course->id => ['status' => 'rejected']]);
                break;
            default:
                return ['success' => false, 'message' => trans('error . unsupported')];
        }
        return ['success' => true];
    }

    /**
     * get 开设课程
     */
    public function courses(Merchant $merchant)
    {
        $items = $merchant->courses()
            ->orderBy('id', 'desc')
            ->wherePivot('status', 'approved')
            ->paginate(10);
        return view('admin.org-manage.course-auth', compact('items', 'merchant'));
    }

    public function points(Request $request, Merchant $merchant)
    {
        $items = $merchant->points()
            ->withCount(['schedules as ongoingSchedules' => function ($query) {
                $query->where('end', '>', date('Y-m-d H:i:s'));
            }])
            ->withCount(['schedules' => function ($query) {
                $query->where('end', '<=', date('Y-m-d H:i:s'));
            }])
            ->orderBy('id', 'desc')
            ->with('schedules');
        if ($request->key) {
            $items->where('name', 'like', '%' . $request->get('key') . '%');
        }
        $items = $items->paginate(10);
        if ($request->key) {
            $items->withPath(route('merchant.points', $merchant) . '?' . http_build_query(['key' => $request->key,]));
        }
        return view('admin.org-manage.edu-location', compact('items', 'merchant'));
    }

    public function orders(Merchant $merchant)
    {
        $items = $merchant->orders()
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.org-manage.amount', compact('items', 'merchant'));
    }

    public function teachers(Request $request, Merchant $merchant)
    {
        $items = $merchant->teachers()
            ->withCount(['coachingSchedules as ongoingSchedules' => function ($query) {
                $query->where('end', '>', Carbon::now()->toDateTimeString());
            }])
            ->withCount(['coachingSchedules' => function ($query) {
                $query->where('end', '<=', Carbon::now()->toDateTimeString());
            }])
            ->orderBy('id', 'desc');

        if ($request->key) {
            $items->where('name', 'like', '%' . $request->get('key') . '%');
        }
        $items = $items->paginate(10);
        if ($request->key) {
            $items->withPath(route('merchant.teachers', $merchant) . '?' . http_build_query(['key' => $request->key,]));
        }
        return view('admin.org-manage.teacher', compact('items', 'merchant'));
    }

    public function teacher(Request $request, Merchant $merchant, User $teacher)
    {
        return view('admin.org-manage.teacher-show', compact('teacher', 'merchant'));
    }

    public function user(Request $request, Merchant $merchant, User $user)
    {
        return view('', compact('merchant', 'user'));
    }

    public function courseApplications(Request $request)
    {
        $isAdmin = $this->isAdmin();
        if ($isAdmin) {
            $items = Course::orderBy('courses.id', 'desc')
                ->join('course_merchant', 'courses.id', '=', 'course_merchant.course_id')
                ->join('merchants', 'merchants.id', 'course_merchant.merchant_id')
                ->select('*')
                ->addSelect('courses.id as course_id')
                ->addSelect('courses.name as course_name')
                ->addSelect('merchants.id as merchant_id')
                ->addSelect('merchants.name as merchant_name')
                ->addSelect('course_merchant.status as status')
                ->addSelect(DB::raw('(select name from users where id=admin_id) as admin_name '))
                ->addSelect(DB::raw('(select phone from users where id=admin_id) as admin_phone '));
            $pointApplicationCount = Point::count();
            $schedulesApplicationCount = Schedule::count();
        } else {
            $merchant = $this->getMerchant();
            $items = $merchant->courses()->orderBy('id', 'desc');
            $pointApplicationCount = Point::where('merchant_id', $merchant->id)->count();
            $schedulesApplicationCount = Schedule::where('merchant_id', $merchant->id)->count();
        }
        if ($request->key) {
            $items->where('merchants.name', 'like', '%' . $request->get('key') . '%');
        }
        $items = $items->paginate(10);
        if ($request->key)
            $items->withPath(route('merchant.course.application') . '?' . http_build_query(['key' => $request->key,]));
        $key = $request->key;
        return view($isAdmin ? 'admin.app-process.add-course' : 'agent.notice.add-course',
            compact('items', 'key', 'pointApplicationCount', 'schedulesApplicationCount'));
    }

    public function courseApplicationQuery()
    {
        return Course::join('course_merchant', 'courses.id', '=', 'course_merchant.course_id');
    }

    public function withdrawApplicationQuery()
    {
        return Application::orderBy('applications.id', 'desc')
            ->with('merchant', 'merchant.admin');
    }

    public function scheduleApplications(Request $request)
    {
        $isAdmin = $this->isAdmin();
        if ($isAdmin) {
            $items = Schedule::with('course', 'merchant', 'merchant.admin');
            $courseApplicationCount = $this->courseApplicationQuery()->count();
            $pointApplicationCount = Point::count();
        } else {
            $merchant = $this->getMerchant();
            $items = $merchant->schedules()->with('merchant');
            $courseApplicationCount = $this->courseApplicationQuery()->where('course_merchant.merchant_id', $merchant->id)->count();
            $pointApplicationCount = Point::where('merchant_id', $merchant->id)->count();
        }
        $items = $items->orderBy('schedules.id', 'desc')
            ->join('merchants', 'schedules.merchant_id', 'merchants.id');
        $items->select('*')
            ->addSelect('schedules.status as schedule_status');
        if ($request->key)
            $items->where('merchants.name', 'like', '%' . $request->key . '%');
        $items = $items->paginate(10);
        if ($request->key)
            $items->withPath(route('merchant.schedule.application') . '?' . http_build_query(['key' => $request->key,]));
        $key = $request->key;
        return view($isAdmin ? 'admin.app-process.course-apply' : 'agent.notice.course-apply',
            compact('items', 'key', 'courseApplicationCount', 'pointApplicationCount'));
    }

    public function pointApplications(Request $request)
    {
        $isAdmin = $this->isAdmin();
        if ($isAdmin) {
            $items = Point::query();
            $courseApplicationCount = $this->courseApplicationQuery()->count();
            $scheduleApplicationCount = Schedule::count();
        } else {
            $merchant = $this->getMerchant();
            $items = $merchant->points();
            $courseApplicationCount = $this->courseApplicationQuery()->where('course_merchant.merchant_id', $merchant->id)->count();
            $scheduleApplicationCount = Schedule::where('merchant_id', $merchant->id)->count();
        }
        $items->join('merchants', 'merchants.id', 'points.merchant_id')
            ->orderBy('points.id', 'desc');
        if ($request->key)
            $items->where('merchants.name', 'like', '%' . $request->get('key') . '%');
        $items->select('*');
        $items->addSelect('points.name as point_name');
        $items->addSelect('points.id as point_id');
        $items->addSelect('merchants.name as merchant_name');
        $items = $items->paginate(10);
        if ($request->key)
            $items->withPath(route('merchant.point.application') . '?' . http_build_query(['key' => $request->key,]));
        $key = $request->key;
        return view($isAdmin ? 'admin.app-process.edu-point' : 'agent.notice.edu-point',
            compact('items', 'key', 'courseApplicationCount', 'scheduleApplicationCount'));
    }

    public function files(Request $request, Merchant $merchant)
    {
        $items = $merchant->files()
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.org-manage.agent-file', compact('items', 'merchant'));
    }

    public function withdrawApplications(Request $request)
    {
        $key = $request->key;
        $items = $this->withdrawApplicationQuery()
            ->join('merchants', 'merchants.id', 'applications.merchant_id');
        if ($request->key)
            $items->where('merchants.name', 'like', '%' . $request->get('key') . '%');
        $items = $items->paginate(10);
        $courseApplicationCount = $this->courseApplicationQuery()->count();
        $scheduleApplicationCount = Schedule::count();
        $pointApplicationCount = Point::count();
        if ($request->key)
            $items->withPath(route('merchant.point.application') . '?' . http_build_query(['key' => $request->key,]));
        return view('admin.app-process.cash', compact('items', 'key',
            'courseApplicationCount', 'scheduleApplicationCount', 'pointApplicationCount'));
    }

}
