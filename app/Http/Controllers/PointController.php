<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Point;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|merchant'])->except(['nearby']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $merchant = auth()->user()->ownMerchant;
        if (!$merchant) {
            abort(500, 'no merchant found');
        }
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
            $items->withPath(route('points.index') . '?' . http_build_query(['key' => $request->key,]));
        }
        $key = $request->key;
        return view('agent.edu-point.index', compact('items', 'key'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agent.edu-point.index');
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
            'name' => 'required',
        ]);
        $item = new Point();
        $item->fill($request->only([
            'name',
            'admin',
            'contact',
            'area',
            'address',
            'province',
            'city',
            'county',
            'geolocation',
            'merchant_id'
        ]));

        $application = new Application(
            $request->only('remark')
        );
        DB::transaction(function () use ($item, $application) {
            $item->save();
            $application->fill([
                'type' => 'point',
                'status' => 'applying',
                'merchant_id' => $this->getMerchant()->id
            ]);
            $item->applications()->save($application);
        });
        return ['success' => true];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Point $point
     * @return \Illuminate\Http\Response
     */
    public function show(Point $point)
    {
	    return view('agent.edu-point.show',compact('point'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Point $point
     * @return \Illuminate\Http\Response
     */
    public function edit(Point $point)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Point $point)
    {
        $point->fill($request->only([
            'name',
            'admin',
            'contact',
            'area',
            'address',
            'province',
            'city',
            'county',
            'geolocation',
        ]));

        $application = new Application(
            $request->only('remark')
        );

        DB::transaction(function () use ($point, $application) {
            $point->save();
            $application->fill([
                'type' => 'point',
                'status' => 'applying',
                'merchant_id' => $this->getMerchant()->id
            ]);
            $point->applications()->save($application);
        });
        return ['success'=>true];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Point $point
     * @return \Illuminate\Http\Response
     */
    public function destroy(Point $point)
    {
        //
    }

    public function nearby(Request $request)
    {
        $location = $request->location;
        if ($location) {
            $items = Point::where('approved', true)->get();
            foreach ($items as $item) {
                $geo = json_decode($item->geolocation);
                $item->distance = count($geo) == 2 ? $this->distance($geo, $location) : INF;
            }
            $sorted = array_sort($items->all(), function ($v) {
                return $v['distance'];
            });
//        dd(array_slice($sorted, 2));
            return $sorted;
        }
        return view('mobile.edu-point');
    }

    public function distance($a, $b)
    {
        return pow($a[0] - $b[0], 2) + pow($a[1] - $b[1], 2);
    }
}
