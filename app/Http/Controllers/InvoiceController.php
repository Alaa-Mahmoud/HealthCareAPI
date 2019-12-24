<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Invoice;
use App\MedicalService;
use App\Notifications\InvoiceIssued;
use App\Sms\SmsService;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['agent']);
    }

    /**
     * @SWG\Get(
     *   path="/invoices",
     *   summary="list all invoices or invoices of specific patient.",
     *   @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Authorization Token.",
     *     required=true,
     *     type="string"
     *   ),
     *     @SWG\Parameter(
     *     name="patient",
     *     in="query",
     *     description="ID of the patient.",
     *     required=false,
     *     type="integer"
     *   ),
     *     @SWG\Parameter(
     *     name="perPage",
     *     in="query",
     *     description="size of list returned  per page.",
     *     required=false,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     description="Page numbetr.",
     *     required=false,
     *     type="integer"
     *   ),
     *   tags={"Invoices"},
     *   @SWG\Response(response=200, description="successful operation")
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $perPage = $request->perPage ? $request->perPage : 10;

        $invoices = Invoice::with('user')
                            ->with('medicalServices')
                            ->filter($request)
                            ->paginate($perPage);

        return $this->successResponse($invoices);
    }

    /**
     * @SWG\Post(
     *   path="/invoices",
     *   summary="Agent Create invoice for patient.",
     *    @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Authorization Token.",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="user_id",
     *     in="formData",
     *     description="ID of patient.",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="discount",
     *     in="formData",
     *     description="discount for the invoice.",
     *     required=false,
     *     type="float"
     *   ),
     *     @SWG\Parameter(
     *     name="discount_type",
     *     in="formData",
     *     description="discount type could be flat or percentage.",
     *     required=false,
     *     type="string"
     *   ),
     *     @SWG\Parameter(
     *     name="medical_service_ids[]",
     *     in="formData",
     *     description="",
     *     required=false,
     *     type="array",
     *    @SWG\Items(
     *             type="integer",
     *             format="int32"
     *         ),
     *    collectionFormat="multi",
     *         uniqueItems=true,
     *   ),
     *   tags={"Invoices"},
     *   @SWG\Response(response=201, description="created"),
     *   @SWG\Response(response=400, description="bad request")
     * )
     *
     */
    public function store(InvoiceStoreRequest $request , SmsService $smsService)
    {
        $data = $request->validated();
        $medicalServices = MedicalService::find($data['medical_service_ids']);
        $amount = $this->calculateInvoiceAmount($medicalServices);
        $total_amount = $this->calculateInvoiceTotalAmount($data , $amount);
        $invoiceData = [
            'user_id' => $data['user_id'],
            'amount' => $amount,
            'total_amount' => $total_amount,
            'discount' => isset($data['discount']) ? $data['discount'] : 0 ,
            'discount_type' => isset($data['discount_type']) && isset($data['discount']) ? $data['discount_type'] : null
        ];
        $invoice = Invoice::create($invoiceData);
        foreach ($medicalServices as $medicalService) {
            $invoice->medicalServices()->attach($medicalService['id'], ['price' => $medicalService['price']]);
        }
        $this->SendInvoiceIssuedNotification($smsService , $data['user_id']);
        return $this->successResponse($invoice);
    }

    protected function calculateInvoiceAmount($medicalServices)
    {
        return $medicalServices->sum(function ($medicalService){
             return $medicalService->price;
        });
    }

    protected function calculateInvoiceTotalAmount($data , $amount)
    {
        if (isset($data['discount'])) {
            if (isset($data['discount_type']) &&  $data['discount_type'] == 'percentage') {
                return $amount - ($amount * $data['discount'] / 100);
            }
            return $amount - $data['discount'];
        }
        return $amount;
    }

    protected function SendInvoiceIssuedNotification(SmsService $smsService , $userId)
    {
        $user = User::find($userId);
        $user->notify(new InvoiceIssued());
        $smsService->send($user , 'Hello customer your invoice has been issued please pay it as soon as possible.');
    }

}
