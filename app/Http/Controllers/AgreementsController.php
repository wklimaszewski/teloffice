<?php

namespace App\Http\Controllers;

use App\Models\agreements_service;
use App\Models\company;
use App\Models\customer;
use App\Models\service;
use App\Models\agreement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;

class AgreementsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin_company');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('Admin_Company');
        if(auth()->user()->role == 1)
        {
            $agreements = Db::table('agreements')
                ->join('companies', 'agreements.company_id', '=', 'companies.id')
                ->join('users', 'companies.user_id','=','users.id')
                ->join('customers', 'agreements.customer_id','=','customers.id')
                ->select('agreements.*', 'companies.name as company', 'customers.name as customer_name', 'customers.surname as customer_surname')
                ->get();
        }
        else
        {
            $agreements = Db::table('agreements')
                ->join('companies', 'agreements.company_id', '=', 'companies.id')
                ->join('users', 'companies.user_id','=','users.id')
                ->join('customers', 'agreements.customer_id','=','customers.id')
                ->select('agreements.*', 'companies.name as company', 'customers.name as customer_name', 'customers.surname as customer_surname')
                ->where('users.id','=',auth()->user()->id)
                ->get();
        }
//        dd($agreements);
        return view('agreements.index', compact('agreements'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = company::all();
        $customers = customer::all();

        return view('agreements.create', compact('companies', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'company_id' => 'required',
            'duration' => 'required',
            'start_price' => 'required',
            'price_for_month' => 'required',
        ]);

        $agreement = new agreement();
        $agreement_number  = (agreement::latest()->first() == null) ? 206739 : agreement::latest()->first()->number+1;
        $agreement->customer_id = $request->customer_id;
        $agreement->company_id = $request->company_id;
        $agreement->duration = $request->duration;
        $agreement->start_price = $request->start_price;
        $agreement->price_for_month = $request->price_for_month;
        $agreement->number = $agreement_number;

        $agreement->save();

        return redirect()->route('agreements.index')->with('success', 'Pomyślnie dodano umowę !');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\agreement $agreement
     * @return \Illuminate\Http\Response
     */
    public function edit(agreement $agreement)
    {
        return view('agreements.edit', compact('agreement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, agreement $agreement)
    {
        $request->validate([
            'duration' => 'required',
            'start_price' => 'required',
            'price_for_month' => 'required',
        ]);
        $agreement->update($request->all());

        return redirect()->route('agreements.index')
            ->with('success', 'Umowa edytowana poprawnie' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function destroy(agreement $agreement)
    {
        $agreement->delete();
        return redirect()->route('agreements.index')
            ->with('success', 'Umowa usunięta pomyślnie!');
    }

}
