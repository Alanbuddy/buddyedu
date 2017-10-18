<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\OrderPaid;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class UserController extends Controller
{
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

}
