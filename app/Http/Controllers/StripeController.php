<?php

namespace App\Http\Controllers;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Http\Request;

class StripeController extends Controller
{
        public function pay()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Sandbox Test Payment',
                    ],
                    'unit_amount' => 1500, // $15
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        return 'Payment Success ✅';
    }

    public function cancel()
    {
        return 'Payment Cancelled ❌';
    }

}
