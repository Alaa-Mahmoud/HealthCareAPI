<?php


namespace App\Billing;


class PaymentProviderY implements PaymentGateway
{

    public function charge($amount)
    {
       return [
           'paymentReference' => 'xyz-abc',
           'success' => true
       ];
    }
}
