<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Course;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\Point;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    use WithdrawTrait;

    public function __construct()
    {
        $this->middleware('role:admin')->except('store');
        $this->middleware('role:merchant')->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Application::withdrawType()
            ->orderBy('id', 'desc')
            ->paginate(10);
        $key = $request->key;
        return view('', compact('items', 'key'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * merchant role
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
        ]);
        $merchant = $this->getMerchant();
        $item = new Application($request->only(['type']));
        $item->merchant_id = $merchant->id;
        switch ($request->type) {
            case 'withdraw':
                return $this->storeWithdrawApplication($request, $item);
                break;
        }
    }

    private function storeWithdrawApplication(Request $request, $item)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
        ]);
        $item->amount = $request->amount * 100;
        $item->object_id = 0;
        $item->save();
        if ($request->ajax())
            return ['success' => true];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Application $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
    }

    public function approve(Request $request, Application $application)
    {
        $method = 'approve' . ucfirst($application->type);
        return $this->{$method}($request, $application);
    }

    public function reject(Request $request, Application $application)
    {
        $method = 'reject' . ucfirst($application->type);
        return $this->{$method}($request, $application);
    }

    public function approveWithdraw(Request $request, Application $application)
    {
        $merchant = $application->merchant;
        if ($application->status == 'applying')
            DB::transaction(function () use ($merchant, $application) {
                $merchant->decrement('balance', $application->amount);
                $application->update(['status' => 'approved']);
                $order = new Order([
                    'title' => 'withdraw',
                    'user_id' => auth()->user()->id,
                    'product_id' => 0,
                    'status' => 'created',
                    'amount' => -$application->amount,
                    'merchant_id' => $merchant->id,
                    'uuid' => 'test'
                ]);
                $order->save();
            });
        return ['success' => true];
    }


    public function approveCourse(Request $request, Application $application)
    {
        $this->validate($request, ['is_batch' => 'numeric']);
        $course = Course::findOrFail($application->object_id);
        DB::transaction(function () use ($request, $course, $application) {
            $application->merchant
                ->courses()
                ->syncWithoutDetaching([
                    $course->id => [
                        'status' => 'approved',
                        'is_batch' => $request->get('is_batch', false)
                    ]
                ]);
            $application->update(['status' => 'approved', 'advice' => $request->advice]);
        });
        return ['success' => true];
    }

    public function rejectCourse(Request $request, Application $application)
    {
        $course = Course::findOrFail($application->object_id);
        DB::transaction(function () use ($request, $course, $application) {
            $application->merchant
                ->courses()
                ->detach($course->id);
            $application->update(['status' => 'rejected', 'advice' => $request->advice]);
        });
        return ['success' => true];
    }

    public function approveSchedule(Request $request, Application $application)
    {
        $schedule = Schedule::findOrFail($application->object_id);
        DB::transaction(function () use ($request, $schedule, $application) {
            $schedule->update(['status' => 'approved']);
            $application->update(['status' => 'approved', 'advice' => $request->advice]);
        });
        return ['success' => true];
    }

    public function rejectSchedule(Request $request, Application $application)
    {
        $schedule = Schedule::findOrFail($application->object_id);
        DB::transaction(function () use ($request, $schedule, $application) {
            $schedule->update(['status' => 'rejected']);
            $application->update(['status' => 'rejected', 'advice' => $request->advice]);
        });
        return ['success' => true];
    }

    public function approvePoint(Request $request, Application $application)
    {
        $point = Point::findOrFail($application->object_id);
        DB::transaction(function () use ($request, $point, $application) {
            $point->update(['approved' => true]);
            $application->update(['status' => 'approved', 'advice' => $request->advice]);
        });
        return ['success' => true];
    }

    public function rejectPoint(Request $request, Application $application)
    {
        $point = Point::findOrFail($application->object_id);
        DB::transaction(function () use ($request, $point, $application) {
            $point->update(['approved' => false]);
            $application->update(['status' => 'rejected', 'advice' => $request->advice]);
        });
        return ['success' => true];
    }
}
