<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomCreateRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoomsController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return RoomResource::collection(Room::all());
    }

    public function store(RoomCreateRequest $request): RoomResource
    {
        return new RoomResource(Room::create($request->all()));
    }

    public function show(Room $room): RoomResource
    {
        return new RoomResource($room);
    }
}
