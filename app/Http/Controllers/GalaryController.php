<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Models\Galary;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class GalaryController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');

        if ($category == 'Photo') {
            $galary = Galary::plick('id')
            ->with('images', ['id', 'path', 'alt_'.app()->getLocale()])
            ->get();
        }

        if ($category == 'Video') {
            $galary = Galary::plick('id')
            ->with('videos', ['id', 'path', 'description_'.app()->getLocale()])
            ->get();
        }

        return ApiResponseService::success($galary);
    }
}
