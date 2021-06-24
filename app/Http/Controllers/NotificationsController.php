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
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\Admin_Company;
use App\Http\Middleware\Mid_Customer;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin_company')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role == 1)
        {
            $notifications = Db::table('notifications')
                ->join('services', 'notifications.service_id','=','services.id')
                ->join('companies', 'services.company_id','=','companies.id')
                ->join('customers', 'notifications.customer_id','=','customers.id')
                ->select('notifications.*', 'services.name as service', 'companies.name as company','customers.name as customer_name', 'customers.surname as customer_surname')
                ->get();
        }
        else
        {
            $notifications = Db::table('notifications')
                ->join('services', 'notifications.service_id','=','services.id')
                ->join('companies', 'services.company_id','=','companies.id')
                ->join('users', 'companies.user_id','=','users.id')
                ->join('customers', 'notifications.customer_id','=','customers.id')
                ->select('notifications.*', 'services.name as service', 'companies.name as company','customers.name as customer_name', 'customers.surname as customer_surname')
                ->where('users.id', auth()->user()->id)
                ->get();
        }
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer_id = customer::where('user_id', Auth::user()->id)->first();

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
            array_push($array2, $s->service_id);
        }

        $services = service::whereIn('id', $array2)->get();

        return view('notifications.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer_id = customer::where('user_id', Auth::user()->id)->first();
        $notification = new notification();
        $notification->customer_id = $customer_id->id;
        $notification->service_id = $request->service_id;
        $notification->description = $request->description;
        $notification->address = $request->miasto." ".$request->ulica." ".$request->kod_pocztowy;

        $notification->save();

        return redirect()->route('zgloszenia')->with('success','Pomyślanie dodano zgłoszenie');
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

    public function update_status(Request $request)
    {
        $notification = notification::find($request->id);
        $notification->status = $request->status;
        $notification->save();


        return redirect()->route('notifications.index')->with('success', 'Status zmieniono  pomyślnie');
    }
}
