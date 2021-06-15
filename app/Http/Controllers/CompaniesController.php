<?php

namespace App\Http\Controllers;

use App\Models\area;
use App\Models\company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = DB::table('companies')
            ->join('areas' , 'companies.area_id' , '=','areas.id')
             ->select ('companies.id', 'companies.name', 'companies.address','companies.description', 'companies.phone', 'companies.email',
             'companies.nip', 'companies.account_number', 'areas.county')
                ->get();

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = area::all();
        return view('companies.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!company::where('user_id',Auth::user()->id)->exists() && Auth::user()->role == 2)
        {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'nip' => 'required',
                'account_number' => 'required',
                'area_id' => 'required',
            ]);

            $request->request->add(['user_id' => Auth::user()->id]);
            $company = company::create($request->all());

            if($request->hasFile('logo'))
            {
                $logo = $request->file('logo')->getClientOriginalName();
                $request->file('logo')->storeAs('public/logos', "logo_".$company->id.'.png','');
            }
        }
        return view('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(company $company)
    {
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(company $company)
    {
        $area = area::where('id', $company->area_id)->first();
        $areas = area::all();
        return view('companies.edit', compact('company', 'area', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, company $company)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'description' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'nip' => 'required',
            'account_number' => 'required',
        ]);
        $company->update($request->all());

        return redirect()->route('companies.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')
            ->with('success', 'Product deleted successfully');
    }
}
