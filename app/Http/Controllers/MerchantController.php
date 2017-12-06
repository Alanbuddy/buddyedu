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
            $admin = User::create([
                'name' => $data['adminName'],
                'phone' => $data['phone'],
                'password' => $data['password'],
                'api_token' => Uuid::uuid(),
            ]);
            $admin->attachRole(Role::find(1));
            $item->fill([
                'name' => $data['name'],
                'admin_id' => $admin->id
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

    /**
     * 课程授权
     */
    public function authorizeCourse(Merchant $merchant, Course $course, $operation)
    {
        switch ($operation) {
            case 'apply':
                $merchant->courses()->syncWithoutDetaching([$course->id => ['status' => 'applying']]);
                break;
            case 'authorize':
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
     * @param Merchant $merchant
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function courses(Merchant $merchant)
    {
        return $merchant->courses()
            ->wherePivot('status', 'approved')
            ->get();
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
