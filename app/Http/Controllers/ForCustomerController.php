<?php

namespace App\Http\Controllers;

use App\Models\area;
use App\Models\company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ForCustomerController extends Controller
{
    public function show_companies(Request $request)
    {

        $companies = company::all();
        $areas = area::all();
        if($request->name != null)
        {
            if($request->area_id!=0)
            {
                $companies = company::where('name','LIKE', '%'.$request->name.'%')->where('area_id','=', $request->area_id)->get();
            }
            else
            {
                $companies = company::where('name','LIKE', '%'.$request->name.'%')->get();
            }
        }
        else if($request->area_id!=0)
        {
            $companies = company::where('area_id','=', $request->area_id)->get();
        }

        return view('user/companies', compact('companies', 'areas'));
    }

}
