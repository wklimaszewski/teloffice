<?php

namespace App\Http\Controllers;

use App\Models\db_invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Services\PaypalService;


class PaymentController extends Controller
{
    private $paypalService;

    function __construct(PaypalService $paypalService){

        $this->paypalService = $paypalService;

    }
    public function getExpressCheckout($orderId)
    {
        $response = $this->paypalService->createOrder($orderId);

        if($response->statusCode !== 201) {
            abort(500);
        }

        foreach ($response->result->links as $link) {
            if($link->rel == 'approve') {
                return redirect($link->href);
            }
        }

    }

    public function cancelPage()
    {
        dd("Nie udało się");
    }

    public function getExpressCheckoutSuccess(Request $request, $orderId)
    {
        $order = db_invoice::where('id',$orderId);
        $order->confirm = 1;
        $order->save();
        return redirect()->route('faktury')->withMessage('Payment successful!');

    }
}
