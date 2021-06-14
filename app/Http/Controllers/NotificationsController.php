<?php

namespace App\Http\Controllers;

use App\Models\agreement;
use App\Models\agreements_service;
use App\Models\customer;
use App\Models\notification;
use App\Models\service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_id = customer::where('id', Auth::user()->id)->first();

        $agreement_id = agreement::where('customer_id', $customer_id->id)->get();

        $array = array();

        foreach ($agreement_id as $a)
        {
            array_push($array, $a->id);
        }

        $services_id = agreements_service::whereIn('agreement_id', $array )->get();

        $array2 = array();

        foreach ($services_id as $s)
        {
            array_push($array2, $s->id);
        }
//        dd($array2);
        $services = service::whereIn('id', $array2)->get();

        return view('notifications.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        $notification = new notification();
        $notification->service_id = $request->service_id;
        $notification->description = $request->description;
        $notification->address = $request->miasto." ".$request->ulica." ".$request->kod_pocztowy;

        $notification->save();

        return view('notifications.index'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
