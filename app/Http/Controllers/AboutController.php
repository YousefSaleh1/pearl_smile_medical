<?php

namespace App\Http\Controllers;

use App\Http\Resources\AboutResource;
use App\Models\About;
use App\Models\WorkingTime;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * get contact information
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContactsInfo()
    {
        $contacts_info = About::select(
            'id',
            'email',
            'facebook_link',
            'instegram_link',
            'tiktok_link',
            'phone_number',
            'mobile_numbers',
            'whatsapp',
            'address_' . app()->getLocale()
        )
            ->first();

        return ApiResponseService::success($contacts_info);
    }

    /**
     * get the About Us page content 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAboutUs()
    {
        $about = About::select('id', 'description_'.app()->getLocale())
        ->with(['videos' => function ($query) {
            $query->select('id', 'videoable_type', 'videoable_id', 'path', 'description_' . app()->getLocale());
        }])
        ->first();

        return ApiResponseService::success(new AboutResource($about));
    }



    /**
     *  get clinic's Working Times
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWorkingTimes() {
        $workingTime= WorkingTime::select('id', 'days','of_time','until_time')->first();
        return ApiResponseService::success($workingTime);
    }
}
