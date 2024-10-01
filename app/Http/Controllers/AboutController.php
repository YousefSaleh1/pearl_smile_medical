<?php

namespace App\Http\Controllers;

use App\Http\Resources\AboutResource;
use App\Models\About;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
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

    public function getAboutUs()
    {
        $about = About::select('id', 'description_'.app()->getLocale())
        ->with(['videos' => function ($query) {
            $query->select('id', 'videoable_type', 'videoable_id', 'path', 'description_' . app()->getLocale());
        }])
        ->first();

        return ApiResponseService::success(new AboutResource($about));
    }
}
