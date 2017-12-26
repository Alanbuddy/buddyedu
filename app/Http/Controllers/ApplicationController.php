<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Course;
use App\Models\Merchant;
use App\Models\Point;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Application::WithdrawType()
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
     *
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
        $item = new Application($request->only(['type', 'merchant_id']));
        switch ($request->type) {
            case 'withdraw':
                return $this->storeWithdrawApplication($request, $item);
                break;
        }
    }

    private function storeWithdrawApplication(Request $request, $item)
    {
        $item->amount = $request->amount;
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
            });
        return ['success' => true];
    }


    public function approveCourse(Request $request, Application $application)
    {
        $course = Course::findOrFail($application->object_id);
        DB::transaction(function () use ($course, $application) {
            $application->merchant
                ->courses()
                ->syncWithoutDetaching([$course->id => ['status' => 'approved']]);
            $application->update(['status' => 'approved']);
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
            $application->update(['status' => 'rejected', 'remark' => $request->remark]);
        });
        return ['success' => true];
    }

    public function approveSchedule(Request $request, Application $application)
    {
        $schedule = Schedule::findOrFail($application->object_id);
        DB::transaction(function () use ($request, $schedule, $application) {
            $schedule->update(['status' => 'approved']);
            $application->update(['status' => 'approved', 'remark' => $request->remark]);
        });
        return ['success' => true];
    }

    public function rejectSchedule(Request $request, Application $application)
    {
        $schedule = Schedule::findOrFail($application->object_id);
        DB::transaction(function () use ($request, $schedule, $application) {
            $schedule->update(['status' => 'rejected']);
            $application->update(['status' => 'rejected', 'remark' => $request->remark]);
        });
        return ['success' => true];
    }

    public function approvePoint(Request $request, Application $application)
    {
        $point = Point::findOrFail($application->object_id);
        DB::transaction(function () use ($request, $point, $application) {
            $point->update(['approved' => true]);
            $application->update(['status' => 'approved', 'remark' => $request->remark]);
        });
        return ['success' => true];
    }

    public function rejectPoint(Request $request, Application $application)
    {
        $point = Course::findOrFail($application->object_id);
        DB::transaction(function () use ($request, $point, $application) {
            $point->update(['approved' => false]);
            $application->update(['status' => 'rejected', 'remark' => $request->remark]);
        });
        return ['success' => true];
    }
}
