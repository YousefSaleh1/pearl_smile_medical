<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\MedicalTeam;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Http\Resources\Service\ServiceDetailResource;
use App\Http\Resources\Service\ServiceSliderResource;
use App\Http\Resources\Service\ServicesNamesResource;
use App\Http\Resources\MedicalTeam\SpecialistsNamesResource;

class ServiceController extends Controller
{
    public function index()
    {
        // جلب الحقول المطلوبة من services مع جلب العلاقة service_images وتحديد الحقول المطلوبة
        $services = Service::select('id', 'title_' . app()->getLocale())
            ->with(['service_images' => function ($query) {
                $query->select('id', 'imageable_type', 'imageable_id', 'path', 'alt_' . app()->getLocale()); // حدد الحقول المطلوبة هنا
            }])
            ->get();

        return ApiResponseService::success(ServiceSliderResource::collection($services));
    }


    public function show(Service $service) {
        $service->load(['sections','faqs', 'offers','medical_teams','service_images']);
        return ApiResponseService::success(new ServiceDetailResource($service));
    }


    /**
     * get the number of services and Specialists in the clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function getClinicInfo()
    {
        $data = [
            'servicers_count' => Service::count(),
            'specialists_count' => MedicalTeam::count(),
        ];

        return ApiResponseService::success($data);
    }


    /**
     * get list of names of services provided by the clinic
     * @return \Illuminate\Http\JsonResponse
     */
    public function getServicesNames(){
        $services = Service::select('id','title_' . app()->getLocale())->get();
        return ApiResponseService::success(ServicesNamesResource::collection($services));

    }



}
