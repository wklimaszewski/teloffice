<?php

namespace App\Http\Controllers;

use App\Models\agreement;
use App\Models\agreements_service;
use App\Models\company;
use App\Models\customer;
use App\Models\db_invoice;
use App\Models\notification;
use App\Models\service;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role==1)
            $invoices = db_invoice::all();
        elseif (auth()->user()->role==2)
        {
            $invoices = Db::table('db_invoices')
                ->join('agreements', 'db_invoices.agreement_id','=','agreements.id')
                ->join('companies', 'agreements.company_id', '=', 'companies.id')
                ->join('users', 'companies.user_id','=','users.id')
                ->select('db_invoices.*')
                ->where('users.id','=',auth()->user()->id)
                ->get();
        }
        else
        {
            $invoices = Db::table('db_invoices')
                ->join('agreements', 'db_invoices.agreement_id','=','agreements.id')
                ->join('customers', 'agreements.customer_id', '=', 'customers.id')
                ->join('users', 'customers.user_id','=','users.id')
                ->select('db_invoices.*')
                ->where('users.id','=',auth()->user()->id)
                ->get();
        }

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->middleware('Admin_Company');
        if(auth()->user()->role==1)
            $agreements = agreement::all();
        else if(auth()->user()->role==2)
        {
            $company = company::where('user_id', auth()->user()->id)->first();
            $agreements = agreement::where('company_id',$company->id )->get();
        }

        return view('invoices.create', compact('agreements'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $invoice = new db_invoice();
        $invoice->agreement_id = $request->agreement;
        $invoice->number = rand(1000000,9999999);
        $invoice->price = (float) $request->price;

        $invoice->save();

        $agreement = agreement::where('id', $request->agreement)->first();
        //$invoice_id, $agreement_id, $company_id, $customer_id
        $this->create_pdf($invoice->id, $agreement->id, $agreement->company_id, $agreement->customer_id);

        return redirect()->route('invoices.index')
            ->with('success', 'Product updated successfully');
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

    public function update_status(Request $request)
    {
        $invoices = db_invoice::find($request->id);
        if($invoices->confirm == 1)
            $invoices->confirm = 0;
        else
            $invoices->confirm = 1;
        $invoices->save();

        return redirect()->route('invoices.index')->with('success', 'Status zmieniono  pomyślnie');
    }

    public function create_pdf($invoice_id, $agreement_id, $company_id, $customer_id)
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

        // And return invoice itself to browser or have a different view
        return $invoice->stream();
    }
}
