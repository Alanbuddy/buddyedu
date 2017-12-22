<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
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
        //
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

}
