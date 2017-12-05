<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin|merchant')->only([
            'store',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = auth()->user()
            ->ownMerchant
            ->points()
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('agent.edu-point.index', compact('items'));
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

        $item->save();
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
        //
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
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Point $point
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Point $point)
    {
        //
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

    public function approve(Point $point, $operation)
    {
        $point->approved = $operation == 'approve' ? true : false;
        return ['success' => true];
    }
}
