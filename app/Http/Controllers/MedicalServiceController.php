<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalServiceStoreRequest;
use App\Http\Requests\MedicalServiceUpdateRequest;
use App\MedicalService;
use App\MedicalServiceType;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class MedicalServiceController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['agent'])->only(['store', 'update']);
    }

    /**
     * @SWG\Get(
     *   path="/medical-services",
     *   summary="list and/or filter medical services by name and/or description and/or type.",
     *   @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Authorization Token.",
     *     required=true,
     *     type="string"
     *   ),
     *     @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     description=" Medical service name.",
     *     required=false,
     *     type="string"
     *   ),
     *    @SWG\Parameter(
     *     name="description",
     *     in="query",
     *     description=" Medical service discription.",
     *     required=false,
     *     type="string"
     *   ),
     *    @SWG\Parameter(
     *     name="type",
     *     in="query",
     *     description=" Medical service type.",
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
     *    @SWG\Parameter(
     *     name="page",
     *     in="query",
     *     description="Page numbetr.",
     *     required=false,
     *     type="integer"
     *   ),
     *   tags={"Medical Services"},
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
        $medicalServices = MedicalService::with('medicalServiceType')
                                        ->filter($request)
                                        ->paginate($perPage);
        return $this->successResponse($medicalServices);
    }
    /**
     * @SWG\Post(
     *   path="/medical-services",
     *   summary="Create medical service.",
     *    @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Authorization Token.",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="name",
     *     in="formData",
     *     description="name of the medical service.",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="description",
     *     in="formData",
     *     description="Description of the medical service.",
     *     required=true,
     *     type="string"
     *   ),
     *     @SWG\Parameter(
     *     name="medical_service_type_id",
     *     in="formData",
     *     description="ID of medical service type.",
     *     required=true,
     *     type="integer"
     *   ),
     *     @SWG\Parameter(
     *     name="price",
     *     in="formData",
     *     description=" Price of the medical service 'price format only 2 digits after the point x.xx' .",
     *     required=true,
     *     type="number"
     *   ),
     *   tags={"Medical Services"},
     *   @SWG\Response(response=201, description="created"),
     *   @SWG\Response(response=422, description="unprocessable entity"),
     *   @SWG\Response(response=403, description="forbidden")
     * )
     *
     */
    public function store(MedicalServiceStoreRequest $request)
    {
        $data = $request->validated();
        $medicalServiceType = MedicalServiceType::findOrFail($data['medical_service_type_id']);
        $medicalService = $medicalServiceType->medicalServices()->create($data);
        return $this->successResponse($medicalService);
    }

    /**
     * @SWG\Put(
     *   path="/medical-services/{medical_service}",
     *   summary="Update medical service.",
     *    @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     description="Authorization Token.",
     *     required=true,
     *     type="string"
     *   ),
     *     @SWG\Parameter(
     *     name="medical_service",
     *     in="path",
     *     description="ID of the medical service.",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="name",
     *     in="formData",
     *     description="name of the medical service.",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="description",
     *     in="formData",
     *     description="Description of the medical service.",
     *     required=false,
     *     type="string"
     *   ),
     *     @SWG\Parameter(
     *     name="medical_service_type_id",
     *     in="formData",
     *     description="ID of medical service type.",
     *     required=false,
     *     type="integer"
     *   ),
     *     @SWG\Parameter(
     *     name="price",
     *     in="formData",
     *     description=" Price of the medical service 'price format only 2 digits after the point x.xx' .",
     *     required=false,
     *     type="number"
     *   ),
     *   tags={"Medical Services"},
     *   @SWG\Response(response=201, description="created"),
     *   @SWG\Response(response=422, description="unprocessable entity"),
     * )
     *
     */

    public function update(MedicalServiceUpdateRequest $request, MedicalService $medicalService)
    {
        $data = $request->validated();
        $medicalService->update($data);
        return $this->successResponse($medicalService);
    }

}
