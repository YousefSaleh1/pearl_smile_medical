<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::select('id')
            ->with(['images' => function ($query) {
                $query->select('id', 'imageable_type', 'imageable_id', 'path', 'alt_' . app()->getLocale()); // حدد الحقول المطلوبة هنا
            }])
            ->get();
        return ApiResponseService::success(OfferResource::collection($offers));
    }
}
