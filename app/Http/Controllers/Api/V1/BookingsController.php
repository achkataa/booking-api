<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\BookingCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingCreateRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['room', 'customer'])->get();
        return BookingResource::collection($bookings);
    }

    public function store(BookingCreateRequest $request)
    {
        $booking = Booking::createWithTotalPrice($request->all());

        event(new BookingCreated($booking));

        return new BookingResource($booking);

    }
}
