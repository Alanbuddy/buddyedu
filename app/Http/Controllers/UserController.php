<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticatesUsersBySms;
use App\Models\Merchant;
use App\Models\Role;
use App\Models\User;
use App\Notifications\OrderPaid;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Server\RequestEvent;

class UserController extends Controller
{
    use AuthenticatesUsersBySms;

    public function __construct()
    {
        $this->middleware('auth')->except(['']);
        $this->middleware('role:admin|merchant')->except(['']);
    }

    public function index()
    {

    }

    public function teacherIndex()
    {
        $user = auth()->user();
        $items = $user->ownMerchant
            ->teachers()
            ->paginate(10);
        return view('agent.teacher.index', compact('items'));
    }

    public function show(User $user)
    {
        dd($user->notifications()->get());
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
        if ($request->has('merchant_id')) {
            return $this->storeTeacher($request);
        }

    }


    public function storeTeacher(Request $request)
    {
        $data = $request->only(['name', 'phone', 'merchant_id']);
        $user = null;
        DB::transaction(function () use ($request, $user, $data) {
            $user = User::create([
                'name' => $data['name'],
                'password' => bcrypt('secret'),
                'phone' => $data['phone'],
                'merchant_id' => $data['merchant_id'],
                'type' => 'teacher',
                'api_token' => Uuid::uuid()
            ]);
            $user->attachRole(Role::where('name', 'teacher')->first());
            $merchant = Merchant::find($request->get('merchant_id'));
            $merchant->teachers()->save($user);
        });
        return $user;
    }

    public function studentPainting(Request $request, User $user)
    {

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

    public function drawings(Request $request)
    {
        $items = auth()->user()->drawings();
        if ($request->has('schedule_id')) {
            $items->where('schedule_id', $request->get('schedule_id'));
        }
        $items = $items->paginate(10);
        return view('', compact('items'));
    }

    public function schedules(Request $request)
    {
        $items = auth()->user()
            ->schedules()
            ->get();
        return $items;
        return view('', compact('items'));
    }
}
