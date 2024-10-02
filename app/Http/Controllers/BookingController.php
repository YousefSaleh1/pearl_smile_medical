<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * booking a service from services that the clinic provide to customer 
     * @param \App\Http\Requests\BookingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookingRequest $request)
    {
        $data = $request->validated();
        $booking = Booking::create([
            'service_id'   => $data['service_id'],
            'name'         => $data['name'],
            'email'        => $data['email'],
            'phone_number' => $data['phone_number'],
            'message'      => $data['message'],
        ]);

        return ApiResponseService::success($booking, 'general.create_booking_sucss', 201);
    }
}
