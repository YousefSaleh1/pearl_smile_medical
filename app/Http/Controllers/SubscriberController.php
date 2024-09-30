<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Http\Requests\SubscriberRequest;

class SubscriberController extends Controller
{

    public function store(SubscriberRequest $request){
        $data = $request->validated();
        $subscriber = Subscriber::create([
            'email' => $data['email']
        ]);
        // return trans('general.create_subscriber_sucss');
        // return $subscriber;
        return ApiResponseService::success($subscriber, 'general.create_subscriber_sucss', 201);
    }
}
