<?php

namespace App\Http\Controllers;

use App\Http\Resources\MedicalTeam\MedicalTeamSliderResource;
use App\Models\MedicalTeam;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class MedicalTeamController extends Controller
{
    public function index()
    {
        $medicalTeams = MedicalTeam::select('id', 'name_' . app()->getLocale(), 'specializations_' . app()->getLocale())
            ->with(['images' => function ($query) {
                $query->select('id', 'imageable_type', 'imageable_id', 'path', 'alt_' . app()->getLocale()); // حدد الحقول المطلوبة هنا
            }])
            ->get();

        return ApiResponseService::success(MedicalTeamSliderResource::collection($medicalTeams));
    }
}
