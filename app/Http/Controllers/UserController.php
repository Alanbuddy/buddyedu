<?php

namespace App\Http\Controllers;

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
    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'store']);
    }

    public function index()
    {

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
        DB::transaction(function () use ($user, $data) {
            $user = User::create([
                'name' => $data['name'],
                'password' => bcrypt('secret'),
                'api_token' => Uuid::uuid()
            ]);
            $user->attachRole(Role::where('name', 'teacher')->first());
        });
        return $user;
    }

}
