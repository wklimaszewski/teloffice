<?php

namespace App\Http\Controllers;

use App\Models\company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ForCustomerController extends Controller
{
    public function show_companies()
    {
        $companies = company::all();
//        dd(Storage::url('logos/logo_10.png'));
        return view('user/companies', compact('companies'));
    }
}
