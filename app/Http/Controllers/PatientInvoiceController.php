<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientInvoiceController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['patient']);
    }

    /**
     * @SWG\Get(
     *   path="/medical-service-types",
     *   summary="List medical service types.",
     *   @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Authorization Token.",
     *     required=true,
     *     type="string"
     *   ),
     *     @SWG\Parameter(
     *     name="perPage",
     *     in="query",
     *     description="size of list returned  per page.",
     *     required=false,
     *     type="integer"
     *   ),
     *    @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     description="Page numbetr.",
     *     required=false,
     *     type="integer"
     *   ),
     *   tags={"Medical Service Types"},
     *   @SWG\Response(response=200, description="successful operation")
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = request()->perPage ? request()->perPage : 10;
        $user = Auth::user();
        $invoices = $user->invoices()
                        ->with('medicalServices')
                        ->paginate($perPage);
        return $this->successResponse($invoices);
    }
}
