<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Http\Resources\PhotoGalleryResource;
use App\Http\Resources\VideoGalleryResource;
use App\Models\Galary;
use App\Models\PhotoGallery;
use App\Models\VideoGallery;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function photoGallery()
    {
        $photo_gallery = PhotoGallery::with(['images' => function ($query) {
            $query->select('id', 'imageable_type', 'imageable_id', 'path', 'alt_' . app()->getLocale());
        }])
            ->get();

        return ApiResponseService::success(PhotoGalleryResource::collection($photo_gallery));
    }

    public function videoGallery()
    {
        $video_gallery = VideoGallery::with(['videos' => function ($query) {
            $query->select('id', 'videoable_type', 'videoable_id', 'path', 'description_' . app()->getLocale());
        }])
            ->get();

        return ApiResponseService::success(VideoGalleryResource::collection($video_gallery));
    }
}
