<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
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
            $services = DB::table('services')
                ->join('companies', 'services.company_id', '=', 'companies.id')
                ->select('services.*', 'companies.name as company')
                ->get();
        }
        else
        {
            $services = DB::table('services')
                ->join('companies', 'services.company_id', '=', 'companies.id')
                ->join('users', 'companies.user_id', '=','users.id')
                ->select('services.*', 'companies.name as company')
                ->where('users.id', auth()->user()->id)
                ->get();
        }

        return  view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->middleware('Admin_Company');
        if(auth()->user()->role == 1)
        {
            $companies = company::all();
        }
        else
        {
            $companies = company::where('user_id', auth()->user()->id)->get();
        }

        return view('services.create', compact('companies'));
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
            'name' => ['required', 'max:70'],
            'company_id' => 'required',
            'description' => ['required', 'max:250'],
            'start_price' => 'required|numeric',
            'price_for_month' => 'required',
        ]);

        service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Pomyślnie dodano usługę');
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
