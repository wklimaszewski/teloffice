<?php

namespace App\Http\Controllers;

use App\Models\agreement;
use App\Models\agreements_service;
use App\Models\company;
use App\Models\customer;
use App\Models\db_invoice;
use App\Models\service;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = db_invoice::all();
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agreements = agreement::all();
        $customers = customer::all();
        $companies = company::all();
        return view('invoices.create', compact('agreements', 'customers', 'companies'));
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
        $invoice->number += 1 ;
        $invoice->price = $request->price;

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
//        dd($service_list);

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
//        $items = [
//            (new InvoiceItem())->title('Service 1')->pricePerUnit(47.79)->quantity(2)->discount(10),
//            (new InvoiceItem())->title('Service 2')->pricePerUnit(71.96)->quantity(2),
//            (new InvoiceItem())->title('Service 3')->pricePerUnit(4.56),
//            (new InvoiceItem())->title('Service 4')->pricePerUnit(87.51)->quantity(7)->discount(4),
//            (new InvoiceItem())->title('Service 5')->pricePerUnit(71.09)->quantity(7)->discountByPercent(9),
//        ];

        $notes = [
            'Faktura została wygenerowana za pośrednictwem TELOFFICE',
        ];
        $notes = implode("<br>", $notes);

        $invoice = Invoice::make('FAKTURA')
            ->series('BIG')
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol('PLN')
            ->currencyCode('PLN')
            ->currencyFormat('{VALUE}{SYMBOL}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            ->notes($notes)
            ->logo(public_path('images/logo.png'))
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice->stream();
    }
}
