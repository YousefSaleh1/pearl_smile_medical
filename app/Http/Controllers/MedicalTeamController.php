<?php

namespace App\Http\Controllers;

use App\Models\MedicalTeam;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Http\Resources\MedicalTeam\SpecialistInfoResource;
use App\Http\Resources\MedicalTeam\SpecialistsNamesResource;
use App\Http\Resources\MedicalTeam\MedicalTeamSliderResource;

class MedicalTeamController extends Controller
{
    /**
     * get  all Specialists with there images 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $medicalTeams = MedicalTeam::select('id', 'name_' . app()->getLocale(), 'specializations_' . app()->getLocale())
            ->with(['images' => function ($query) {
                $query->select('id', 'imageable_type', 'imageable_id', 'path', 'alt_' . app()->getLocale()); // حدد الحقول المطلوبة هنا
            }])
            ->get();

        return ApiResponseService::success(MedicalTeamSliderResource::collection($medicalTeams));
    }


    /**
     * get names of all Specialists in the clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpecialistsNames() {
        $medicalTeams = MedicalTeam::select('id', 'name_' . app()->getLocale())->get();
        return ApiResponseService::success(SpecialistsNamesResource::collection($medicalTeams));
    }


    public function show(MedicalTeam $specialist) {
        $specialist->load('services');
        return ApiResponseService::success(new SpecialistInfoResource($specialist));
    }

}
