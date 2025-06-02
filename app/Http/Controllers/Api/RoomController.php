<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        return response()->json(Room::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|unique:rooms,room_number',
            'type' => 'required|in:Standard,Deluxe,Suite,Presidential,Penthouse',
            'status' => 'required|in:available,occupied,reserved,maintenance',
            'floor' => 'required|integer',
            'price' => 'required|numeric',
            'last_cleaned' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'description' => 'nullable|string',
            'capacity' => 'required|integer',
            'area' => 'nullable|numeric',
            'bed_type' => 'required|string',
        ]);

        $room = Room::create($validated);

        return response()->json([
            'message' => 'Room created successfully',
            'room' => $room,
        ], 201);
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return response()->json($room);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'room_number' => 'sometimes|unique:rooms,room_number,' . $id,
            'type' => 'sometimes|in:Standard,Deluxe,Suite,Presidential,Penthouse',
            'status' => 'sometimes|in:available,occupied,reserved,maintenance',
            'floor' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
            'last_cleaned' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'description' => 'nullable|string',
            'capacity' => 'sometimes|integer',
            'area' => 'nullable|numeric',
            'bed_type' => 'sometimes|string',
        ]);

        $room->update($validated);

        return response()->json([
            'message' => 'Room updated successfully',
            'room' => $room,
        ]);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return response()->json(['message' => 'Room deleted successfully']);
    }
}
