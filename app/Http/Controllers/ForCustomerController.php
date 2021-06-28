<?php

namespace App\Http\Controllers;

use App\Models\agreement;
use App\Models\agreements_service;
use App\Models\area;
use App\Models\company;
use App\Models\customer;
use App\Models\db_invoice;
use App\Models\notification;
use App\Models\service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;
use Response;

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
                if($request->area_id==17)
                    $companies= company::all();
                else
                    $companies = company::where('name','LIKE', '%'.$request->name.'%')->where('area_id','=', $request->area_id)->get();
            }
            else
            {
                $companies = company::where('name','LIKE', '%'.$request->name.'%')->get();
            }
        }
        else if($request->area_id!=0)
        {
            if($request->area_id==17)
                $companies= company::all();
            else
                $companies = company::where('area_id','=', $request->area_id)->get();
        }

        return view('user/companies', compact('companies', 'areas'));
    }
    public function show_services(Request $request)
    {
        $services = service::where('company_id', $request->company_id)->get();

        return view('user/services', compact('services'));
    }

    public function show_agreements()
    {
        $customer = customer::where('user_id', auth()->user()->id)->first();
        $agreements = agreement::where('customer_id', $customer->id)
            ->join('companies','agreements.company_id','=','companies.id')
            ->join('agreements_services','agreements_services.agreement_id','=','agreements.id')
            ->join('services', 'agreements_services.service_id','=','services.id')
            ->select('agreements.*', 'companies.name as company', 'services.name as service')
            ->get();

        return view('user/agreements', compact('agreements'));
    }

    public function show_invoices()
    {
        $customer = customer::where('user_id', auth()->user()->id)->first();
        $invoices = agreement::where('customer_id', $customer->id)
            ->join('db_invoices', 'db_invoices.agreement_id','=','agreements.id')
            ->join('companies','agreements.company_id','=','companies.id')
            ->join('agreements_services','agreements_services.agreement_id','=','agreements.id')
            ->join('services', 'agreements_services.service_id','=','services.id')
            ->select('db_invoices.*', 'companies.name as company', 'services.name as service', 'agreements.number as agreement')
            ->get();
        $invoices_pp = agreement::where('customer_id', $customer->id)
            ->join('db_invoices', 'db_invoices.agreement_id','=','agreements.id')
            ->join('companies','agreements.company_id','=','companies.id')
            ->join('agreements_services','agreements_services.agreement_id','=','agreements.id')
            ->join('services', 'agreements_services.service_id','=','services.id')
            ->where('db_invoices.confirm','=',0)
            ->select('db_invoices.*', 'companies.name as company', 'services.name as service', 'agreements.number as agreement')
            ->get();

        return view('user/invoices', compact('invoices', 'invoices_pp'));
    }

    public function show_notifications()
    {
        $customer = customer::where('user_id', auth()->user()->id)->first();

        $notifications = notification::where('customer_id', $customer->id)
            ->join('services','notifications.service_id','=','services.id')
            ->join('companies','services.company_id','=','companies.id')
            ->select('notifications.*', 'services.name as service', 'companies.name as company')
            ->get();
        return view('user/notifications', compact('notifications'));
    }

    public function confirm(Request $request)
    {
        $service_id = $request->service_id;
        $service = service::where('id',$service_id)->first();
        $company = company::where('id', $service->company_id)->first();

        $customer = customer::where('user_id', auth()->user()->id)->first();

        return view('user/confirm', compact('customer', 'company', 'service'));
    }

    public function done(Request $request)
    {
        $customer = json_decode($request->customer);
        $company = json_decode($request->company);
        $service = json_decode($request->service);
//        dd($request->duration);
//        dd(agreement::latest()->first()->number+1);

        $agreement_number  = (agreement::latest()->first()->number == null) ? 206739 : agreement::latest()->first()->number+1;
        $agreement = agreement::create([
            'customer_id' => $customer->id,
            'company_id' => $company->id,
            'number' => $agreement_number,
            'duration' => $request->duration,
            'start_price' => $service->start_price,
            'price_for_month' => $service->price_for_month
        ]);

        $agreement_service = agreements_service::create([
            'agreement_id' => $agreement->id,
            'service_id' =>$service->id
        ]);

        $invoice_number  = (db_invoice::latest()->first()->number == null) ? 415142 : db_invoice::latest()->first()->number+1;

        $invoice = db_invoice::create([
            'agreement_id' => $agreement->id,
            'number' => $invoice_number,
            'price' => $agreement->start_price+$agreement->price_for_month,
        ]);

        $this->agreement_pdf($agreement->id);
        $this->invoice_pdf($invoice->id, $agreement->id, $company->id, $customer->id);

        return view('user/info', compact('agreement', 'invoice'));
    }



    public function agreement_pdf($id)
    {
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
        $pdf->save('docs/agreements/'.$agreement->id.'.pdf');

//        return $pdf->download('umowa_'.$agreement->number.'.pdf',['Content-Type' => 'application/pdf']);
    }

    public function invoice_pdf($invoice_id, $agreement_id, $company_id, $customer_id)
    {
        $invoice = db_invoice::where('id', $invoice_id)->first();
        $agreement = agreement::where('id', $agreement_id)->first();
        $company = company::where('id', $company_id)->first();
        $contractor = customer::where('id', $customer_id )->first();

        $service_id = agreements_service::select('service_id')->where('agreement_id', $agreement_id)->get();

        $array = array();
        foreach($service_id as $id)
        {
            array_push($array, $id->service_id);
        }

        $service_list = service::whereIn('id', $array)->get();

        $client = new Party([
            'name' => $company->name,
            'phone' => $company->phone,
            'email' => $company->email,
            'custom_fields' => [
                'Adres' => $company->address,
                'NIP' => $company->nip,
                'Numer konta bankowego' => $company->account_number,
            ],
        ]);

        $customer = new Party([
            'name' => $contractor->name." ". $contractor->surname,
            'phone' => $contractor->phone,
            'email' => $contractor->email,
            'address'       => $contractor->address,
            'custom_fields' => [
                'Pesel' => $contractor->pesel,
            ],
        ]);

        $items = array();
        array_push($items,(new InvoiceItem())->title('Instalacja')->pricePerUnit($agreement->start_price) );

        foreach ($service_list as $service)
        {
            array_push($items, (new InvoiceItem())->title($service->name)->pricePerUnit($service->price_for_month) );
        }

        $notes = [
            'Faktura została wygenerowana za pośrednictwem TELOFFICE',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('FAKTURA')
            ->series('BIG')
            ->sequence($invoice->number)
            ->serialNumberFormat('FAKTURA/{SEQUENCE}')
            ->seller($client)
            ->buyer($customer)
            ->date(now())
            ->dateFormat('d/m/Y')
            ->payUntilDays(30)
            ->currencySymbol('PLN')
            ->currencyCode('PLN')
            ->currencyFormat('{VALUE}{SYMBOL}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($invoice->id)
            ->addItems($items)
            ->notes($notes)
            ->logo(public_path('images/logo.png'))
            // You can additionally save generated invoice to configured disk
            ->save('invoices');

//        return $invoice->download(['Content-Type' => 'application/pdf']);
    }

    public function pobierz_umowe(Request $request)
    {
        $file= "docs/agreements/".$request->agreement.".pdf";

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($file, 'Umowa.pdf', $headers);
    }

    public function pobierz_fakture(Request $request)
    {
        $file= "storage/invoices/".$request->invoice.".pdf";

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($file, 'Fatura.pdf', $headers);
    }

    public function map()
    {
        $companies = company::all();
        return view('user/map_companies', compact('companies'));
    }

    public function map_check(Request $request)
    {
        $woj = $request->woj;

        if($woj== "województwo podlaskie")
            $area_id= 1;
        else if($woj == "województwo mazowieckie")
            $area_id = 2;
        else if($woj == "województwo pomorskie")
            $area_id = 3;
        else if($woj == "województwo opolskie")
            $area_id = 4;
        else if($woj == "województwo dolnośląskie")
            $area_id = 5;
        else if($woj == "województwo kujawsko-pomorskie")
            $area_id = 6;
        else if($woj == "województwo lubelskie")
            $area_id = 7;
        else if($woj == "województwo lubuskie")
            $area_id = 8;
        else if($woj == "województwo łódzkie")
            $area_id = 9;
        else if($woj == "województwo małopolskie")
            $area_id = 10;
        else if($woj == "województwo podkarpackie")
            $area_id = 11;
        else if($woj == "województwo śląskie")
            $area_id = 12;
        else if($woj == "województwo świętokrzyskie")
            $area_id = 13;
        else if($woj == "województwo warmińsko-mazurskie")
            $area_id = 14;
        else if($woj == "województwo wielkopolskie")
            $area_id = 15;
        else if($woj == "województwo zachodniopomorskie")
            $area_id = 16;

        $array = array();
        array_push($array, $area_id);
        array_push($array, 17);
        $company = company::whereIn('area_id', $array)->get();

        return $company;
    }

    public function pay(Request $request)
    {
        $invoice = db_invoice::find($request->id);

        $invoice->confirm = 1;
        $invoice->save();
        return 1;
    }




}
