<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Merchant;
use App\Models\Role;
use App\Models\User;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MerchantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Merchant::orderBy('id', 'desc')
            ->paginate(10);
        return $items;
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
            'province',
            'city',
            'county',
            'street',
        ]);
        $admin = User::create([
            'name' => $data['adminName'],
            'phone' => $data['phone'],
            'password' => '',
            'api_token' => Uuid::uuid(),
        ]);
        $admin->attachRole(Role::find(1));
        $item = Merchant::create([
            'name' => $data['name'],
            'admin_id' => $admin->id
        ]);
//        $item->address = implode('', $request->only('province', 'city', 'county', 'street'));
        $item->save();
        return $item;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merchant $merchant
     * @return \Illuminate\Http\Response
     */
    public function show(Merchant $merchant)
    {
        //
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

    public function authorizeCourse(Merchant $merchant, Course $course, $operation)
    {
        if ($operation == 'attach') {
            $merchant->courses()->attach($course);
        } else {
            $merchant->courses()->detach($course);
        }
        return ['success' => true];
    }
}
