<?php

namespace App\Http\Controllers;

use App\Http\Resources\Service\ServiceSliderResource;
use App\Models\MedicalTeam;
use App\Models\Service;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

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

    public function getClinicInfo()
    {
        $data = [
            'servicers_count' => Service::count(),
            'specialists_count' => MedicalTeam::count(),
        ];

        return ApiResponseService::success($data);
    }
}
