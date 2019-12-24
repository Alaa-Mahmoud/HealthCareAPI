<?php

namespace App\Http\Controllers;

use App\MedicalServiceType;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class MedicalServiceTypeController extends Controller
{
    use ApiResponser;

    /**
     * @SWG\Get(
     *   path="/patients/invoices",
     *   summary="List patient invoices.",
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
     *   tags={"Patients invoices"},
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
        $medicalServiceTypes = MedicalServiceType::paginate($perPage);
       return $this->successResponse($medicalServiceTypes);
    }
}
