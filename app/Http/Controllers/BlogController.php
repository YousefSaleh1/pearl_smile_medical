<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Filament\Notifications\Collection;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;

class BlogController extends Controller
{
    /**
     * get list of blogs
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){

        $blogs = Blog::select(

            'id',
            'title_'.app()->getLocale(),
            'description_' .app()->getLocale(),
            'tags_' .app()->getLocale(),

        )->with('images',function ($query){
            $query->select('id', 'imageable_type', 'imageable_id', 'path', 'alt_' . app()->getLocale());
        })->get();

        return ApiResponseService::success(BlogResource::collection($blogs));
    }


    /**
     * get blog info by blog id 
     * @param \App\Models\Blog $blog
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Blog $blog){
        $blog->load('images');
        return ApiResponseService::success(new BlogResource($blog));
    }



}
