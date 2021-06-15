<?php

namespace App\Http\Controllers;

use App\Models\agreements_service;
use App\Models\company;
use App\Models\customer;
use App\Models\service;
use App\Models\agreement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;

class AgreementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd("hello");

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agreements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function create_pdf()
    {
        $id=1;
        $pdf = \App::make('dompdf.wrapper');

        $agreement = agreement::where('id', $id)->first();
        $company = company::where('id', $agreement->company_id)->first();
        $customer = customer::where('id', $agreement->customer_id)->first();
        $service_id = agreements_service::select('service_id')->where('agreement_id', $id)->get();

        $array = array();
        foreach($service_id as $id)
        {
            array_push($array, $id->service_id);
        }

        $services = service::whereIn('id', $array)->get();

        $service_name = array();
        foreach ($services as $service)
        {
            array_push($service_name,$service->name.", opłata miesięczna - ".$service->price_for_month);
        }

        $data =
            [
                "customer_name" => $customer->name." ". $customer->surname,
                "customer_address" => $customer->address,
                "customer_phone" => $customer->phone,
                "customer_email" => $customer->email,
                "customer_pesel" => $customer->pesel,
                "company_name" => $company->name,
                "company_nip" => $company->nip,
                "company_address" => $company->address,
                "company_account_number" => $company->account_number,
                "company_phone" => $company->phone,
                "company_email" => $company->email,
                "services" => $service_name,
                "agreement_number" => $agreement->number,
                "agreement_duration" => $agreement->duration,
            ];


        $pdf->loadView('agreements.template', compact('data'));
        return $pdf->stream();
    }
}
