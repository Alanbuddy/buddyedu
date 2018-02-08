<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticatesUsersBySms;
use App\Models\Attendance;
use App\Models\File;
use App\Models\Merchant;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\User;
use App\Notifications\OrderPaid;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use League\OAuth2\Server\RequestEvent;

class UserController extends Controller
{
    use AuthenticatesUsersBySms;

    public function __construct()
    {
        $this->middleware('auth')->except(['showBindPhoneForm']);
        $this->middleware('role:admin|merchant')->except(['showBindPhoneForm', 'bindPhone', 'profile', 'schedules', 'drawings'
            , 'updateProfile', 'storeStudent', 'studentIndex']);
    }

    public function index(Request $request)
    {
        $isAdmin = $this->isAdmin();
        $items = User::orderBy('id', 'desc')
            ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->whereNull('role_id');
        if (!$isAdmin) {
            $merchant = $this->getMerchant();
            $items = $merchant->users();
            $hasBatchCourse = $merchant->courses()->wherePivot('is_batch', true)->count();
        }
        $items->withCount('enrolledShedules')
            ->addSelect(DB::raw('(select round(sum(amount/100),2) from orders where user_id=users.id and orders.status=\'paid\') as total'));
        if ($key = $request->key) {
            $items->where(function ($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%')->orWhere('phone', 'like', '%' . $key . '%');
            });
        }
        $items = $items->paginate(10);
        if ($key)
            $items->withPath(route('users.index') . '?' . http_build_query(['key' => $key,]));
        return view($this->isAdmin() ? 'admin.student.index'
            : 'agent.student.index', compact('items', 'key', 'hasBatchCourse'));

    }

    public function studentIndex(Request $request)
    {
        if ($this->isAdmin()) {
            $items = User::leftJoin('role_user')
                ->whereNull('role_id');
        } else {
            $merchant = $this->getMerchant();
            $items = $merchant->users();
        }

        if ($key = $request->key) {
            $items->where(function ($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%')->orWhere('phone', 'like', '%' . $key . '%');
            });
        }
        if ($scheduleId = $request->schedule_id) {
            $items->addSelect(DB::Raw("(select count(*) from schedule_user where schedule_user.user_id=merchant_user.user_id and schedule_id=$scheduleId) as attended"));
        }
        $items = $items->orderByDesc('id')->paginate(10);
        if ($key)
            $items->withPath(route('students.index') . '?' . http_build_query(['key' => $key,]));
        return ['success' => true, 'data' => $items];
    }

    public function adminIndex(Request $request)
    {
        $items = Role::where('name', 'merchant')
            ->first()->users()
            ->orderBy('users.id', 'desc');
        if ($request->has('key')) {
            $items->where('name', 'like', '%' . $request->key . '%')
                ->orWhere('phone', 'like', '%' . $request->key . '%');
        }
        $items = $items->paginate(10);
        if ($request->has('key')) {
            $items->withPath(route('admins.index') . '?' . http_build_query(['key' => $request->key,]));
        }
        $key = $request->key;
        return view('admin.user.index', compact('items', 'key'));
    }

    public function teacherIndex(Request $request)
    {
        $user = auth()->user();
        $items = $user->ownMerchant
            ->teachers()
            ->withCount(['coachingSchedules as ongoingSchedules' => function ($query) {
                $query->where('end', '>', Carbon::now()->toDateTimeString());
            }])
            ->withCount(['coachingSchedules' => function ($query) {
                $query->where('end', '<=', Carbon::now()->toDateTimeString());
            }])
            ->orderBy('id', 'desc');

        if ($request->key) {
            $items->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('key') . '%')
                    ->orWhere('phone', 'like', '%' . $request->get('key') . '%');
            });
        }
        $items = $items->paginate(10);
        if ($request->key) {
            $items->withPath(route('teachers.index') . '?' . http_build_query(['key' => $request->key,]));
        }
        $key = $request->key;
        return view('agent.teacher.index', compact('items', 'key'));
    }

    public function show(User $user)
    {
        $isAdmin = $this->isAdmin();
        $items = $user->schedules()
            ->with('point', 'merchant', 'course', 'teachers');

        $items = $items->paginate(10);
        return view($isAdmin ? 'admin.student.show' : 'agent.student.show', compact('items', 'user'));
    }

    public function notifications()
    {
        $user = auth()->user();
        $items = $user->notifications()
            ->where('type', OrderPaid::class)
            ->paginate(10);
        foreach ($items as $item) {
            $item->has_read = $item->read();
        }
        return $items;
    }

    public function notificationShow($notification)
    {
        $notification = auth()->user()->notifications()->find($notification);
        $notification->markAsRead();
        dd($notification);
    }

    public function store(Request $request)
    {
//        $this->validate($request)
        if ($request->has('merchant_id')) {
            return $this->storeTeacher($request);
        } else {
            return $this->storeStudent($request);
        }

    }

    public function storeStudent(Request $request)
    {
        $this->validate($request, [
            'phone' => 'unique:users|max:20',
            'name' => 'required|max:20',
            'gender' => Rule::in(['male', 'female']),
            'birthday' => 'required|date',
        ]);
        $result = null;
        $user = User::where('phone', $request->phone)->first();
        DB::transaction(function () use (&$user, $request, &$result) {
            if (!$user)
                $user = User::create(array_merge(
                    ['password' => bcrypt('secret')],
                    $request->only('phone', 'name', 'gender', 'birthday')
                ));
            if (!$this->isAdmin())
                $this->getMerchant()->users()->syncWithoutDetaching([$user->id]);
        });
//        dd(json_encode($result));
        return ['success' => true, 'data' => $user];
    }

    public function storeTeacher(Request $request)
    {
        $user = null;
        DB::transaction(function () use ($request, $user) {
            $user = User::create([
                'name' => $request->name,
                'password' => bcrypt('secret'),
                'phone' => $request->phone,
                'avatar' => $request->avatar,
                'gender' => $request->gender,
                'birthday' => $request->birthday,
                'merchant_id' => auth()->user()->ownMerchant->id,
//                'type' => 'teacher',
                'api_token' => Uuid::uuid(),
                'extra' => json_encode($request->only([
                    'title', 'certificate_id', 'id', 'school', 'introduction', 'cv', 'teaching_age'
                ])),
            ]);
            $user->attachRole(Role::where('name', 'teacher')->first());
            $merchant = Merchant::find($request->get('merchant_id'));
            $merchant->teachers()->save($user);
        });
        return ['success' => true, 'data' => $user];
    }


    public function showBindPhoneForm(Request $request)
    {
        return view('mobile.info');
    }

    public function bindPhone(Request $request)
    {
        $result = $this->validateCode($request);
        if ($result['success']) {
            auth()->user()->update([
                'phone' => $request->get('phone')
            ]);
            return ['success' => true];
        }
        return ['success' => false];
    }

    public function update(Request $request, User $user)
    {
        $data = $request->only('birthday', 'name', 'gender');
        $user->update($data);
        return ['success' => true];
    }

    public function drawingsQuery()
    {
        return auth()->user()->drawings()
            ->select(DB::raw('group_concat(files.name) as names'))
            ->addSelect(DB::raw('group_concat(files.id) as ids'))
            ->addSelect(DB::raw('date_format(files.created_at,\'%Y-%m-%d\') created_at'))
            ->groupBy(DB::raw('date_format(files.created_at,\'%Y-%m-%d\')'))
            ->orderBy('created_at', 'desc');
//        dd($items,auth()->user()->id);
    }

    public function drawings(Request $request)
    {
//        $items = auth()->user()->drawings();
        $items = $this->drawingsQuery();
        if ($request->has('schedule_id')) {
            $items->where('schedule_id', $request->get('schedule_id'));
        }
        $items = $items->paginate(10);
        foreach ($items as $item) {
            $ids = explode(',', $item->ids);
            $item->files = File::whereIn('id', $ids)->orderBy('id', 'desc')->get();
        }
//        dd($items);
        return view('mobile.product-list', compact('items'));
    }

    public function videos(Request $request)
    {
        $items = auth()->user()->videos();
        $items = $items->orderBy('id', 'desc')
            ->paginate(10);
        return view('mobile.product-list', compact('items'));
    }

//    public function drawing(Request $request, File $drawing)
//    {
//        $video = File::where('uuid', $drawing->uuid)->first();
//        return view('mobile.student-product', compact('drawing', 'video'));
//    }

    public function schedules(Request $request)
    {
        // $user = auth()->user();
        // $items = $user
        //     ->schedules()
        //     ->with('course')
        //     ->orderBy('id', 'desc')
        //     ->paginate();
        // return view('mobile.student-course', compact('items', 'user'));
        return view('grow.curve', compact('', ''));
    }

    public function queryStudent($isAdmin)
    {
        $query = User::join('schedule_user', 'schedule_user.user_id', 'users.id')
            ->where('schedule_user.type', 'student');
        if ($isAdmin) {
            return $query;
        } else {
            return $query->join('schedules', 'schedules.id', 'schedule_user.schedule_id')
                ->where('schedules.merchant_id', auth()->user()->ownMerchant->id);
//            return User::leftJoin('role_user', 'role_user.user_id', '=', 'users.id')->whereNull('role_id')
        }
    }

    public function statistics(Request $request)
    {
        $isAdmin = $this->isAdmin();
        list($left, $right) = $this->getRange($request);
        $countOfToday = $this->queryStudent($isAdmin)
            ->where('users.created_at', '>', date('Y-m-d'))
            ->where('users.created_at', '<', date('Y-m-d', strtotime('today +1 days')))
            ->count();
        $countOfThisWeek = $this->queryStudent($isAdmin)
            ->where('users.created_at', '>', date("Y-m-d", strtotime("-1 week Monday")))
            ->where('users.created_at', '<', date('Y-m-d', strtotime("0 week Monday")))
            ->count();
        $countOfSelectedRange = $this->queryStudent($isAdmin)
            ->where('users.created_at', '>', $left)
            ->where('users.created_at', '<', $right)
            ->count();
        $count = $this->queryStudent($isAdmin)
            ->count();
        $genderDistribution = $this->queryStudent($isAdmin)
            ->select(DB::raw('count(\'gender\') as count'))
            ->addSelect('gender')
            ->groupBy('gender')
            ->get()->toArray();
//        dd($genderDistribution->all());
        $ageDistribution = $this->queryStudent($isAdmin)
            ->select(DB::raw('TIMESTAMPDIFF(YEAR, birthday, CURDATE()) as age'))
            ->groupBy('age')
            ->addSelect(DB::raw('count(*) as count'))
            ->get();

        $arr = [];
        foreach (range($ageDistribution->min('age'), $ageDistribution->max('age')) as $item) {
            $arr[$item] = 0;
        }

        foreach ($ageDistribution as $item) {
            $arr[$item->age] = $item->count;
        }

        $ageDistribution = $arr;
//        $ageDistribution = [];
//        foreach ($arr as $k => $v) {
//            $ageDistribution[] = [
//                'age' => $k,
//                'count' => $v,
//            ];
//        }
//        dd(json_encode($ageDistribution));

        $growingDistribution = $this->queryStudent($isAdmin)
            ->select(DB::raw('weekofyear(users.created_at) as week'))
            ->addSelect(DB::raw('count(*) as count'))
            ->groupBy('week')
            ->get();
        $firstWeek = date('W', strtotime($left));
        $lastWeek = date('W', strtotime($right));
        $arr = [];
        foreach (range($firstWeek, $lastWeek) as $number) {
            $arr[$number] = 0;
        }
        foreach ($growingDistribution as $item) {
            $arr[$item->week] = $item->count;
        }
        $growingDistribution = $arr;
        return view($isAdmin ? 'admin.statistic.index' : 'agent.statistic.index', compact('count',
            'countOfSelectedRange', 'countOfThisWeek', 'countOfToday', 'left', 'right',
            'ageDistribution', 'genderDistribution', 'growingDistribution'));
    }

    public function getRange(Request $request)
    {
//        $left = $request->get('left', date('Y-m-d', strtotime('-1 week Monday')));
        $left = $request->get('left', date('Y-m-d', strtotime('-700 days')));
        $right = $request->get('right', date('Y-m-d'));
        return [$left, $right];
    }

    //后台人员管理-关闭
    public function disable(Request $request, User $user)
    {
        $user->status = 'disabled';
        $user->save();
        return ['success' => true];
    }

    //后台人员管理-开通
    public function enable(Request $request, User $user)
    {
        $user->status = 'enabled';
        $user->save();
        return ['success' => true];
    }

    public function attendances(Request $request, User $user, Schedule $schedule)
    {
        $items = $user->attendances()
            ->where('schedule_id', $schedule->id)
            ->select('ordinal_no')
            ->get()
            ->toArray();
        $arr = [];
        foreach (range(1, $schedule->course->lessons_count) as $item) {
            $arr[$item] = collect($items)->contains(['ordinal_no' => $item]);
        }
        return $arr;
    }

    public function profile(Request $request)
    {
        $user = auth()->user();
        $schedule = session('order.product_id');
        return view('mobile.student-info', compact('user', 'schedule'));
    }

    public function updateProfile(Request $request)
    {
        $data = $request->only('name', 'gender', 'birthday');
        Log::debug($data);
        auth()->user()->update($data);
        return ['success' => true];
    }

    public function destroy(User $user)
    {
        $user->delete();
        return ['success' => true];
    }
}
