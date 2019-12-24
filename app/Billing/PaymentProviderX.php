<?php


namespace App\Billing;


use Illuminate\Support\Facades\Auth;

class PaymentProviderX implements PaymentGateway
{

    public function charge($amount)
    {
        return [
            'customerId' => Auth::user()->id,
            'cardType' => 'Visa',
            '3D-secure-on' => true,
            'success' => true
        ];
    }
}
