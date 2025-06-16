<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;


class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all()->map(function ($room) {
            return [
                'id' => $room->id,
                'room_number' => $room->room_number,
                'type' => $room->type,
                'status' => $room->status,
                'floor' => $room->floor,
                'price' => $room->price,
                'last_cleaned' => $room->last_cleaned,
                'image' => $room->image ? asset('storage/' . $room->image) : null,
                'features' => $room->features,
                'description' => $room->description,
                'capacity' => $room->capacity,
                'area' => $room->area,
                'bed_type' => $room->bed_type,
                'created_at' => $room->created_at,
                'updated_at' => $room->updated_at,
            ];
        });

        return response()->json($rooms);
    }




 public function store(Request $request)
{
    try {
        // Validate the request data
        $validated = $request->validate([
            'room_number' => 'required|string',
            'floor' => 'required|integer',
            'type' => 'required|string',
            'bed_type' => 'required|string',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'area' => 'required|numeric',
            'description' => 'nullable|string',
            'features' => 'nullable|json',
            'status' => 'required|string|in:available,booked,maintenance',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                $path = $request->file('image')->store('image', 'public');
                $validated['image'] = $path;
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
                return response()->json([
                    'message' => 'Image upload failed',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        // Decode features if present
        if (!empty($validated['features'])) {
            try {
                $validated['features'] = json_decode($validated['features'], true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                Log::error('Invalid features JSON: ' . $validated['features']);
                return response()->json([
                    'message' => 'Invalid features format',
                    'error' => $e->getMessage()
                ], 422);
            }
        }

        // Create the room
        $room = Room::create($validated);

        return response()->json([
            'message' => 'Room created successfully',
            'data' => $room,
            'image_url' => $room->image ? asset('storage/' . $room->image) : null,
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation failed: ' . json_encode($e->errors()));
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        Log::error('Room creation failed: ' . $e->getMessage());
        return response()->json([
            'message' => 'Room creation failed',
            'error' => $e->getMessage(),
            'trace' => config('app.debug') ? $e->getTrace() : null
        ], 500);
    }
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
