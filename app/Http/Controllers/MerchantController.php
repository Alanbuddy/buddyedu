<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Merchant;
use App\Models\Point;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
                'password' => $data['password'],
                'status' => 'applying',
                'api_token' => Uuid::uuid(),
            ]);
            $admin->save();
            $admin->attachRole(Role::find(1));
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
    public function show(Merchant $merchant)
    {
        $items=$merchant->ongoingSchedules()
            ->with('point')
            ->with('teachers')
            ->with('students')
            ->paginate(10);
        return  view('admin.org-manage.show',compact('merchant','items'));
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
        return $merchant->courses()
            ->wherePivot('status', 'approved')
            ->get();
    }

    public function getMerchant()
    {
        return auth()->user()->ownMerchant;
    }

    public function courseApplications()
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
        } else {
            $merchant = $this->getMerchant();
            $items = $merchant->courses()
                ->orderBy('id', 'desc');
        }
        $items = $items->paginate(10);
        return view($isAdmin ? 'admin.app-process.add-course' : 'agent.notice.add-course', compact('items'));
    }

    public function scheduleApplications()
    {
        $merchant = $this->getMerchant();
        $items = $merchant->schedules()
            ->with('course')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('agent.notice.course-apply', compact('items'));
    }

    public function pointApplications()
    {
        $isAdmin = $this->isAdmin();
        if ($isAdmin) {
            $items = Point::orderBy('id', 'desc')
                ->with('merchant');
        } else {
            $merchant = $this->getMerchant();
            $items = $merchant->points()
                ->orderBy('id', 'desc');
        }
        $items = $items->paginate(10);
//        dd($items);
        return view($isAdmin ? 'admin.app-process.edu-point' : 'agent.notice.edu-point', compact('items'));
    }

    /**
     * get 教学点
     * @param Merchant $merchant
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function points(Merchant $merchant)
    {
        return $merchant->points()->get();
    }

}
