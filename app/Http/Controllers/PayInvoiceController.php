<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGateway;
use App\Http\Requests\PayInvoiceRequest;
use App\Invoice;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PayInvoiceController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('patient');
    }

    /**
     * @SWG\Post(
     *   path="/invoices/{invoice}/pay",
     *   summary="Update medical service.",
     *    @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Authorization Token",
     *     required=true,
     *     type="string"
     *   ),
     *     @SWG\Parameter(
     *     name="invoice",
     *     in="path",
     *     description="ID of the invoice.",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="provider",
     *     in="formData",
     *     description="name of payment gateway profider 'ProviderX / ProviderY'.",
     *     required=true,
     *     type="string"
     *   ),
     *   tags={"Invoices"},
     *   @SWG\Response(response=201, description="created"),
     *   @SWG\Response(response=400, description="bad request"),
     * )
     *
     */

    public function __invoke(Invoice $invoice , PaymentGateway $paymentGateway , PayInvoiceRequest $request)
    {
        $data = $request->validated();
        if ($invoice->user_id !== Auth::user()->id) {
            return $this->errorResponse('Forbidden', Response::HTTP_FORBIDDEN);
        }
        if (!$invoice->pending) {
            return $this->errorResponse('This invoice already paid before.', Response::HTTP_BAD_REQUEST);
        }
        $paymentGateWayResponse =  $paymentGateway->charge($invoice->total_amount);
        if ($paymentGateWayResponse['success']) {
            $invoice->update(['pending' => false , 'payment_provider' => $data['provider']]);
        }
        return $paymentGateWayResponse;
    }
}
